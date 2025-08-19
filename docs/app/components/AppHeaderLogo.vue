<!---
  - Copyright 2025 (C) IDMarinas - All Rights Reserved
  -
  - Last modified by "IDMarinas" on 19/08/2025, 17:19
  -
  - @project IDMarinas Template Symfony
  - @see https://github.com/idmarinas/template-symfony
  -
  - @file AppHeaderLogo.vue
  - @date 19/08/2025
  - @time 17:31
  -
  - @author Iván Diaz Marinas (IDMarinas)
  - @license BSD 3-Clause License
  -
  - @since 1.0.0
  -->

<script setup lang="ts">
const appConfig = useAppConfig()
</script>

<template>
  <UColorModeImage
    v-if="appConfig.header?.logo?.dark || appConfig.header?.logo?.light"
    :light="appConfig.header?.logo?.light || appConfig.header?.logo?.dark"
    :dark="appConfig.header?.logo?.dark || appConfig.header?.logo?.light"
    :alt="appConfig.header?.logo?.alt || appConfig.header?.title"
    class="h-12 w-auto shrink-0"
  />
  <span v-else>
    {{ appConfig.header?.title || '{appConfig.header.title}' }}
  </span>
</template>
