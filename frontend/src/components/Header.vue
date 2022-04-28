<template>
  <div id="header">
    <button @click="clickOnChange('LegendList')" class="btn-home">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
        />
      </svg>
    </button>

    <div>
      <h1 class="color-white">Legendas de Costa Rica</h1>
      <p class="color-white">Libro Virtual</p>
    </div>

    <button @click="clickOnChange('CreateForm')" class="add-leyend">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
          clip-rule="evenodd"
        />
      </svg>
      Añade tu leyenda
    </button>
  </div>
</template>

<script>
export default {
  name: "Header",
  methods: {
    clickOnChange(value) {
      this.$emit("clickOnChange", {component: value});
    },
  },
};
</script>
