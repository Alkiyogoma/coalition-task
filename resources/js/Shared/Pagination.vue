<template>
  <nav class="py-4 px-4" aria-label="Page navigation example">
    <ul class="pagination pagination-info">
    <li v-for="(link, key) in links" class="page-item"  :class="{'active' : link.active }">
      <Link class="page-link" :key="`link-${key}`"  :href="link.url" v-html="link.label" />
    </li>
  </ul>
</nav>

   <!-- <div class="pagination-container justify-content-center">
      <ul class="pagination pagination-success" v-for="(link, key) in links">
      <li class="page-item" :class="{ 'active': link.active }" >
        <div v-if="link.url === null" :key="key"  v-html="link.label" />
        <a :key="`link-${key}`" class="page-link" :href="link.url" v-html="link.label" />
      </li>
    </ul>
  </div> 
     <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class="mb-1 mr-1 px-2 py-2 text-gray-400 text-sm leading-4 border rounded" v-html="link.label" />
        <Link v-else :key="`link-${key}`" class="mb-1 mr-1 px-2 py-2 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded" :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div> -->
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  components: {
    Link,
  },
  props: {
    links: Array,
  },
}
</script>
