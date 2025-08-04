<!---
  - Copyright 2025 (C) IDMarinas - All Rights Reserved
  -
  - Last modified by "IDMarinas" on 01/08/2025, 19:04
  -
  - @project IDMarinas Template Symfony
  - @see https://github.com/idmarinas/template-symfony
  -
  - @file docs.vue
  - @date 04/08/2025
  - @time 11:49
  -
  - @author Iván Diaz Marinas (IDMarinas)
  - @license BSD 3-Clause License
  -
  - @since 1.0.0
  -->

<template>
  <UContainer>
    <UPage>
      <template #left>
        <UPageAside>
          <DocsAsideLeftTop />

          <AppHeaderBody />
        </UPageAside>
      </template>

      <slot />
    </UPage>
  </UContainer>
</template>
