<!---
  - Copyright 2025 (C) IDMarinas - All Rights Reserved
  -
  - Last modified by "IDMarinas" on 03/08/2025, 21:27
  -
  - @project IDMarinas Template Symfony
  - @see https://github.com/idmarinas/template-symfony
  -
  - @file AppHeaderBody.vue
  - @date 04/08/2025
  - @time 11:52
  -
  - @author Iván Diaz Marinas (IDMarinas)
  - @license BSD 3-Clause License
  -
  - @since 1.0.0
  -->

<script setup lang="ts">
import type { ContentNavigationItem } from '@nuxt/content'

const navigation = inject<Ref<ContentNavigationItem[]>>('navigation')
</script>

<template>
	<DocVersionSelect />

	<USeparator type="dashed" class="my-6" />

  <UContentNavigation
    highlight
    variant="link"
    :navigation="navigation"
  />
</template>
