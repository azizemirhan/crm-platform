/**
 * Advanced jQuery AJAX Filtering for CRM
 */

(function($) {
    'use strict';

    // Lead List Advanced Filtering
    class AdvancedFilter {
        constructor(listType) {
            this.listType = listType; // 'leads' or 'contacts'
            this.debounceTimer = null;
            this.init();
        }

        init() {
            this.bindEvents();
        }

        bindEvents() {
            const self = this;

            // Search input with debounce
            $(document).on('input', `#${this.listType}-search`, function() {
                clearTimeout(self.debounceTimer);
                self.debounceTimer = setTimeout(() => {
                    self.applyFilters();
                }, 300);
            });

            // Status filter
            $(document).on('change', `#${this.listType}-status`, function() {
                self.applyFilters();
            });

            // Source filter
            $(document).on('change', `#${this.listType}-source`, function() {
                self.applyFilters();
            });

            // Owner filter
            $(document).on('change', `#${this.listType}-owner`, function() {
                self.applyFilters();
            });

            // Clear filters
            $(document).on('click', `#${this.listType}-clear-filters`, function(e) {
                e.preventDefault();
                self.clearFilters();
            });

            // Export to CSV
            $(document).on('click', `#${this.listType}-export-csv`, function(e) {
                e.preventDefault();
                self.exportToCSV();
            });
        }

        applyFilters() {
            const filters = this.getFilterValues();

            // Show loading state
            this.showLoading();

            $.ajax({
                url: `/${this.listType}/filter`,
                method: 'GET',
                data: filters,
                dataType: 'json',
                success: (response) => {
                    this.updateTable(response.data);
                    this.updateStats(response.stats);
                    this.updatePagination(response.pagination);
                    this.hideLoading();
                },
                error: (xhr) => {
                    console.error('Filter error:', xhr);
                    this.showError('Filtreleme sırasında bir hata oluştu');
                    this.hideLoading();
                }
            });
        }

        getFilterValues() {
            return {
                search: $(`#${this.listType}-search`).val() || '',
                status: $(`#${this.listType}-status`).val() || '',
                source: $(`#${this.listType}-source`).val() || '',
                owner_id: $(`#${this.listType}-owner`).val() || '',
                page: 1
            };
        }

        clearFilters() {
            $(`#${this.listType}-search`).val('');
            $(`#${this.listType}-status`).val('');
            $(`#${this.listType}-source`).val('');
            $(`#${this.listType}-owner`).val('');
            this.applyFilters();
        }

        updateTable(data) {
            const tbody = $(`#${this.listType}-table-body`);
            tbody.empty();

            if (data.length === 0) {
                tbody.append(this.getEmptyRow());
                return;
            }

            data.forEach(item => {
                tbody.append(this.createTableRow(item));
            });

            // Reinitialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        createTableRow(item) {
            // Override in subclass
            return '';
        }

        getEmptyRow() {
            return `
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Kayıt bulunamadı</h5>
                        </div>
                    </td>
                </tr>
            `;
        }

        updateStats(stats) {
            if (!stats) return;

            Object.keys(stats).forEach(key => {
                $(`#stat-${key}`).text(stats[key]);
            });
        }

        updatePagination(pagination) {
            // Update pagination links
            $('.pagination-container').html(pagination.links);
        }

        showLoading() {
            $(`#${this.listType}-table-body`).addClass('loading');
            $('.spinner-overlay').fadeIn(200);
        }

        hideLoading() {
            $(`#${this.listType}-table-body`).removeClass('loading');
            $('.spinner-overlay').fadeOut(200);
        }

        showError(message) {
            const alert = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $('.alert-container').html(alert);
        }

        exportToCSV() {
            const filters = this.getFilterValues();
            const queryString = $.param(filters);
            window.location.href = `/${this.listType}/export/csv?${queryString}`;
        }
    }

    // Lead specific implementation
    class LeadFilter extends AdvancedFilter {
        createTableRow(lead) {
            const initials = (lead.first_name.charAt(0) + lead.last_name.charAt(0)).toUpperCase();

            return `
                <tr class="table-row-hover">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-2">${initials}</div>
                            <a href="/leads/${lead.id}" class="fw-semibold text-decoration-none text-dark hover-primary">
                                ${lead.first_name} ${lead.last_name}
                            </a>
                        </div>
                    </td>
                    <td><span class="text-muted">${lead.company || '-'}</span></td>
                    <td><span class="badge-modern badge-${lead.status}">${lead.status}</span></td>
                    <td>
                        <div class="score-badge">
                            <i class="bi bi-star-fill text-warning me-1"></i>
                            <span class="fw-semibold">${lead.score || 'N/A'}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(lead.owner?.name || 'NA')}&background=random&size=28"
                                 class="rounded-circle me-2" width="28" height="28">
                            <small class="text-muted">${lead.owner?.name || 'Atanmamış'}</small>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info">
                            <div class="small">
                                <i class="bi bi-envelope text-muted me-1"></i>
                                ${lead.email}
                            </div>
                            ${lead.phone ? `
                                <div class="small text-muted">
                                    <i class="bi bi-telephone me-1"></i>
                                    ${lead.phone}
                                </div>
                            ` : ''}
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="/leads/${lead.id}/edit" class="btn btn-outline-primary btn-sm-modern">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-outline-danger btn-sm-modern" onclick="deleteLead(${lead.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }
    }

    // Contact specific implementation
    class ContactFilter extends AdvancedFilter {
        createTableRow(contact) {
            return `
                <tr class="table-row-hover">
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(contact.full_name)}&background=random&size=40"
                                 class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <a href="/contacts/${contact.id}" class="fw-semibold text-decoration-none text-dark hover-primary d-block">
                                    ${contact.full_name}
                                </a>
                                ${contact.title ? `<small class="text-muted">${contact.title}</small>` : ''}
                            </div>
                        </div>
                    </td>
                    <td>${contact.account ? contact.account.name : '-'}</td>
                    <td>
                        <div class="contact-info">
                            <div class="small">
                                <i class="bi bi-envelope text-muted me-1"></i>
                                ${contact.email}
                            </div>
                            ${contact.phone ? `
                                <div class="small text-muted">
                                    <i class="bi bi-telephone me-1"></i>
                                    ${contact.phone}
                                </div>
                            ` : ''}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 me-2" style="height: 8px; max-width: 100px;">
                                <div class="progress-bar bg-primary" style="width: ${contact.engagement_score || 0}%"></div>
                            </div>
                            <span class="fw-semibold small">${contact.engagement_score || 0}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(contact.owner?.name || 'NA')}&background=random&size=28"
                                 class="rounded-circle me-2" width="28" height="28">
                            <small class="text-muted">${contact.owner?.name || 'Atanmamış'}</small>
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="/contacts/${contact.id}" class="btn btn-outline-info btn-sm-modern">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="/contacts/${contact.id}/edit" class="btn btn-outline-primary btn-sm-modern">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            `;
        }
    }

    // Initialize on page load
    $(document).ready(function() {
        // Check which page we're on
        if ($('#leads-search').length) {
            window.leadFilter = new LeadFilter('leads');
        }

        if ($('#contacts-search').length) {
            window.contactFilter = new ContactFilter('contacts');
        }
    });

})(jQuery);
