# =============================================================================
# SHARED — runs for both staging and production
# =============================================================================

# STAGE 1: DEPENDENCIES
# Installs npm packages once; shared by downstream build stages.
FROM node:20-alpine AS deps

WORKDIR /app

COPY package*.json ./

RUN npm install


# =============================================================================
# STAGING ONLY
# =============================================================================

# STAGING BUILD
# Compiles assets using .env.staging so staging-specific variables are baked in.
FROM deps AS staging-build

COPY . .

RUN npm run build -- --mode staging


# STAGING SERVER
# Serves the staging build via nginx.
# Target with: docker build --target staging
FROM nginx:alpine AS staging

COPY --from=staging-build /app/dist /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]


# =============================================================================
# PRODUCTION ONLY
# =============================================================================

# PRODUCTION BUILD
# Compiles assets using .env.production so production-specific variables are baked in.
FROM deps AS build

COPY . .

RUN npm run build -- --mode production


# PRODUCTION SERVER
# Serves the production build via nginx.
# Target with: docker build --target production
FROM nginx:alpine AS production

COPY --from=build /app/dist /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]