<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User; // Bunu ekledik
use App\Models\Account;     // <-- 1. EKLEYİN
use App\Models\Contact;    // <-- 2. EKLEYİN
use App\Models\Opportunity; // <-- 3. EKLEYİN
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; // Bunu ekledik

class LeadController extends Controller
{
    /**
     * Müşteri adaylarının listelendiği ana sayfayı gösterir.
     * Bu sayfa, <livewire:leads.lead-list /> bileşenini içerebilir.
     */
    public function index()
    {
        // resources/views/leads/index.blade.php dosyasını döndürür.
        return view('leads.index');
    }

    /**
     * Yeni bir müşteri adayı oluşturma formunu gösterir.
     * Bu sayfa, <livewire:leads.lead-form /> bileşenini içerebilir.
     */
    public function create()
    {
        // resources/views/leads/create.blade.php dosyasını döndürür.
        return view('leads.create');
    }

    /**
     * Belirtilen müşteri adayının detay sayfasını gösterir.
     */
    public function show(Lead $lead)
    {
        // Rota-Model bağlaması sayesinde $lead otomatik olarak bulunur.
        // resources/views/leads/show.blade.php dosyasını döndürür.
        return view('leads.show', [
            'lead' => $lead
        ]);
    }

    /**
     * Belirtilen müşteri adayını düzenleme formunu gösterir.
     * Bu sayfa, <livewire:leads.lead-form :lead="$lead" /> bileşenini içerebilir.
     */
    public function edit(Lead $lead)
    {
        return view('leads.edit', [
            'lead' => $lead
        ]);
    }

    /**
     * Belirtilen müşteri adayını veritabanından siler.
     */
    public function destroy(Lead $lead)
    {
        // Yetkilendirme (Policy) kontrolü eklenebilir
        // $this->authorize('delete', $lead);

        $lead->delete();

        // Liste sayfasına bir başarı mesajı ile yönlendir.
        return Redirect::route('leads.index')
            ->with('success', 'Müşteri adayı başarıyla silindi.');
    }

    // --- Müşteri Adayı Eylemleri (Lead Actions) ---

    /**
     * Bir müşteri adayını Kişi, Hesap ve Fırsat'a dönüştürür.
     * Bu, 2. Aşama'da detaylıca doldurulacak en önemli metoddur.
     */
 
    public function convert(Request $request, Lead $lead)
    {
        // 1. Zaten dönüştürülmüş mü diye kontrol et
        if ($lead->converted_at) {
            return Redirect::back()
                ->with('error', 'Bu müşteri adayı zaten dönüştürülmüş.');
        }

        // 2. Veritabanı İşlemi (Transaction) Başlat
        // Bu, işlemlerden biri başarısız olursa tümünü geri alır.
        try {
            DB::beginTransaction();

            // 3. Hesap (Account) Oluştur
            // Önce $lead->company ismiyle bir hesap var mı diye bak, yoksa oluştur.
            $account = Account::firstOrCreate(
                ['name' => $lead->company, 'team_id' => $lead->team_id],
                [
                    'owner_id' => $lead->owner_id,
                    'phone' => $lead->phone,
                    'website' => $lead->website,
                    'source' => $lead->source ?? 'Converted Lead',
                ]
            );

            // 4. Kişi (Contact) Oluştur
            $contact = Contact::create([
                'team_id' => $lead->team_id,
                'account_id' => $account->id, // Oluşturulan hesaba bağla
                'owner_id' => $lead->owner_id,
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'title' => $lead->title,
                'status' => 'active', // Kişiyi 'aktif' olarak başlat
            ]);

            // 5. (Önerilen) Fırsat (Opportunity) Oluştur
            $opportunity = Opportunity::create([
                'team_id' => $lead->team_id,
                'account_id' => $account->id,
                'contact_id' => $contact->id,
                'owner_id' => $lead->owner_id,
                'name' => $lead->company . ' - Yeni Fırsat', // Otomatik bir isim ver
                'stage' => 'qualification', // İlk aşama
                'amount' => $lead->budget ?? 0, // Lead'den bütçeyi al
                'expected_close_date' => $lead->expected_close_date ?? now()->addMonth(),
                'lead_source' => $lead->source,
            ]);

            // 6. Müşteri Adayını (Lead) Güncelle
            $lead->status = 'converted';
            $lead->converted_at = now();
            $lead->converted_contact_id = $contact->id;
            $lead->converted_account_id = $account->id;
            $lead->converted_opportunity_id = $opportunity->id;
            $lead->save();

            // 7. Her şey başarılıysa, işlemi onayla
            DB::commit();

            // 8. Kullanıcıyı yeni oluşturulan Kişi'nin (Contact) detay sayfasına yönlendir
            // (Projenizde Contact detay sayfası varsa)
            // return Redirect::route('contacts.show', $contact)
            //     ->with('success', 'Müşteri adayı başarıyla dönüştürüldü.');
            
            // Alternatif olarak, Lead detay sayfasına geri dön
            return Redirect::route('leads.show', $lead)
                ->with('success', 'Müşteri adayı başarıyla Kişi, Hesap ve Fırsat\'a dönüştürüldü.');

        } catch (\Exception $e) {
            // Bir hata oluşursa, tüm işlemleri geri al
            DB::rollBack();

            // Hata mesajıyla geri dön
            return Redirect::back()
                ->with('error', 'Dönüştürme sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
    /**
     * Müşteri adayını "Nitelikli" (Qualified) olarak işaretler.
     */
    public function qualify(Request $request, Lead $lead)
    {
        // $this->authorize('qualify', $lead);

        $lead->status = 'qualified';
        $lead->qualified_at = now();
        $lead->save();

        // Detay sayfasına bir başarı mesajı ile geri dön.
        return Redirect::back()
            ->with('success', 'Müşteri adayı "Nitelikli" olarak işaretlendi.');
    }

    /**
     * Müşteri adayını "Diskalifiye" (Disqualified) olarak işaretler.
     */
    public function disqualify(Request $request, Lead $lead)
    {
        // $this->authorize('disqualify', $lead);

        $lead->status = 'disqualified';
        // $lead->disqualification_reason = $request->input('reason'); // Formdan sebep gelirse
        $lead->save();

        return Redirect::back()
            ->with('success', 'Müşteri adayı "Diskalifiye" olarak işaretlendi.');
    }
}