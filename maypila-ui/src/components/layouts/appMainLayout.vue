<template>
  <!--
    min-h-screen: sets the minimum height to 100vh so the wrapper fills the full screen height.
    text-foreground: applies the theme's foreground text color to everything inside this div.
    
    text-foreground
	  auth-layout-background
  -->
  <div class="min-h-screen main-theme-bg-color
	">
    <!--
      mx-auto: centers this block horizontally within its parent by using automatic left and right margins.
      flex: makes this div a flex container so its children can be aligned with flexbox utilities.
      min-h-screen: keeps this inner wrapper at least as tall as the viewport.
      items-center: centers children vertically along the cross axis of the flex container.
      justify-center: centers children horizontally along the main axis of the flex container.
      px-0: removes horizontal padding on mobile screens.
      py-0: removes vertical padding on mobile screens.
      md:px-6: adds horizontal padding on tablet screens and up.
      md:py-8: adds vertical padding on tablet screens and up.
      lg:px-10: increases horizontal padding on large screens and up.
      lg:py-10: increases vertical padding on large screens and up.
    -->
    <AppHeaderMenu />
    <div class="mx-auto
      flex
      min-h-screen
      items-center
      justify-center
      px-2
      py-14
      md:px-6
      lg:px-10
      ">
      <!--
        flex: makes the section a flex container so its content can be aligned with flexbox utilities.
        w-full: makes the section take the full available width of its parent.
        max-w-md: limits the section width to the medium max-width size so the form does not stretch too wide.
        items-center: centers children vertically along the cross axis of the flex container.
        justify-center: centers children horizontally along the main axis of the flex container.
      -->
      <RouterView />
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import AppHeaderMenu from '../shared/AppHeaderMenu.vue';
</script>
