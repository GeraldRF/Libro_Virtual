<template>
  <div id="app" class="container">
    <Header @clickOnChange="changeComponent"></Header>
    <div>
      <component
        v-bind:legendId="legendId"
        v-bind:is="current"
        @clickOnChange="changeComponent"
        @clickOnCreate="createLegend"
        @clickOnUpdate="updateLegend"
      ></component>
    </div>
  </div>
</template>

<script>
import Header from "./components/Header.vue";
import LegendList from "./components/LegendList.vue";
import UpdateForm from "./components/UpdateForm.vue";
import CreateForm from "./components/CreateForm.vue";

export default {
  name: "App",
  components: {
    Header,
    LegendList,
    UpdateForm,
    CreateForm,
  },
  data() {
    return {
      current: "LegendList",
      legendId: null,
    };
  },
  methods: {
    changeComponent(value) {
      if (value.legendId != null) {
        this.legendId = value.legendId; 
        this.current = value.component;
      }
      else {
        this.current = value.component;
      }
    },
    createLegend() {
      this.current = "LegendList";
    },
    updateLeged() {
      this.current = "LegendList";
    },
  },
};
</script>

<style>
@import url("./assets/css/app.css");
</style>
