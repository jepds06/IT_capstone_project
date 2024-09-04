<template>
    <button :type="type" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700" @click="onClick">
      <slot></slot>
    </button>
  </template>
  
  <script>
  export default {
    props: {
      type: {
        type: String,
        default: 'button',
      },
    },
    methods: {
      onClick(event) {
        this.$emit('click', event);
      },
    },
  };
  </script>
  