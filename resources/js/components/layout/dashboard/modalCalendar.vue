<template>

  </template>
  
  <script>
  export default {
    methods: {
      closeModal() {
        this.$emit('close');
      },
      handleSubmit() {
        
      }
    }
  };
  </script>
  
  <style>
  .modal-bg {
    background: rgba(0, 0, 0, 0.5);
  }
  </style>