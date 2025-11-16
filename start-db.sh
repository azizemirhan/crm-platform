#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🚀 Starting PostgreSQL for CRM Platform...${NC}\n"

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}❌ Docker is not running!${NC}"
    echo -e "${YELLOW}Please start Docker Desktop and try again.${NC}\n"
    echo "On macOS: Open Docker Desktop application"
    exit 1
fi

# Start PostgreSQL container
echo -e "${GREEN}✓ Docker is running${NC}"
echo -e "${YELLOW}Starting PostgreSQL container...${NC}\n"

docker-compose -f docker-compose.local.yml up -d

# Wait for PostgreSQL to be ready
echo -e "\n${YELLOW}Waiting for PostgreSQL to be ready...${NC}"
sleep 5

# Check if PostgreSQL is healthy
if docker-compose -f docker-compose.local.yml ps | grep -q "healthy\|Up"; then
    echo -e "${GREEN}✓ PostgreSQL is ready!${NC}\n"

    # Show connection info
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${GREEN}PostgreSQL Connection Info:${NC}"
    echo -e "  Host: ${YELLOW}localhost${NC} or ${YELLOW}127.0.0.1${NC}"
    echo -e "  Port: ${YELLOW}5432${NC}"
    echo -e "  Database: ${YELLOW}crm_platform${NC}"
    echo -e "  Username: ${YELLOW}crm_user${NC}"
    echo -e "  Password: ${YELLOW}secret${NC}"
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}\n"

    # Offer to run migrations
    echo -e "${YELLOW}Do you want to run migrations now? (y/n)${NC}"
    read -r answer

    if [ "$answer" = "y" ] || [ "$answer" = "Y" ]; then
        echo -e "\n${YELLOW}Running migrations...${NC}\n"
        php artisan migrate
        echo -e "\n${YELLOW}Running tenant migrations...${NC}\n"
        php artisan tenants:migrate
        echo -e "\n${GREEN}✓ Migrations completed!${NC}"
    else
        echo -e "\n${YELLOW}To run migrations later, use:${NC}"
        echo "  php artisan migrate"
        echo "  php artisan tenants:migrate"
    fi

    echo -e "\n${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${GREEN}Useful Commands:${NC}"
    echo -e "  Stop PostgreSQL: ${YELLOW}docker-compose -f docker-compose.local.yml down${NC}"
    echo -e "  View logs: ${YELLOW}docker-compose -f docker-compose.local.yml logs -f${NC}"
    echo -e "  Restart: ${YELLOW}docker-compose -f docker-compose.local.yml restart${NC}"
    echo -e "  Access Adminer: ${YELLOW}http://localhost:8081${NC} (if using full docker-compose.yml)"
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}\n"
else
    echo -e "${RED}❌ PostgreSQL failed to start${NC}"
    echo -e "${YELLOW}Check logs with: docker-compose -f docker-compose.local.yml logs${NC}"
    exit 1
fi
