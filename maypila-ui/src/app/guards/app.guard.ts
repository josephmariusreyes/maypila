import type { RouteLocationNormalized } from 'vue-router'

export function canAccessRoute(to: RouteLocationNormalized) {

    const requiresAuth = to.matched.some((routeRecord) => routeRecord.meta.requiresAuth);
    console.log(requiresAuth);
    // Returning true tells Vue Router to continue to the requested route.
    return true;
}