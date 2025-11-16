#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🛑 Stopping PostgreSQL...${NC}\n"

# Stop PostgreSQL container
docker-compose -f docker-compose.local.yml down

echo -e "\n${GREEN}✓ PostgreSQL stopped successfully!${NC}\n"

echo -e "${YELLOW}Note: Data is preserved in Docker volume 'postgres-data'${NC}"
echo -e "${YELLOW}To completely remove data, run: docker-compose -f docker-compose.local.yml down -v${NC}\n"
