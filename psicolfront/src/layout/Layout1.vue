<template>
  <div class="layout-wrapper layout-1">
    <div class="layout-inner">
      <div class="layout-container">

        <div class="layout-content">
          <div class="router-transitions container-fluid flex-grow-1 container-p-y">
            <router-view />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'app-layout-1',

  mounted () {

  },

  beforeDestroy () {

  }
}
</script>
