<!---
  - Copyright 2025 (C) IDMarinas - All Rights Reserved
  -
  - Last modified by "IDMarinas" on 19/08/2025, 17:52
  -
  - @project IDMarinas Template Symfony
  - @see https://github.com/idmarinas/template-symfony
  -
  - @file HeaderVersionSelect.vue
  - @date 19/08/2025
  - @time 17:57
  -
  - @author Iván Diaz Marinas (IDMarinas)
  - @license BSD 3-Clause License
  -
  - @since 1.0.0
  -->

<script lang="ts" setup>
const {version, items} = useDocsVersioning()
</script>

<template>
  <UDropdownMenu
    :items="items"
    :modal="false"
    :ui="{
      content: 'min-w-4',
      itemLabel: 'truncate flex-1'
    }"
  >
    <template #default="{ open }">
      <UBadge
        :color="version.tagColor"
        class="cursor-default"
        variant="subtle"
        trailing-icon="i-lucide-chevron-down"
        :ui="{trailingIcon: ['transition-transform duration-200', open ? 'rotate-180' : undefined].filter(Boolean).join(' ')}">
        {{ version.tag }}
      </UBadge>
    </template>

    <template #item-label="{ item }">
      <UBadge :color="item.tagColor" size="sm" variant="subtle">
        {{ item.tag }}
      </UBadge>
    </template>
  </UDropdownMenu>
</template>
