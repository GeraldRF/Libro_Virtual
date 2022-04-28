<template>
  <div id="legend-list" class="color-white">
    <div class="filter">
      <label for="filter">Busqueda:</label>
      <input
        type="text"
        v-model="value"
        name="filter"
        id="filter"
        placeholder="Buscar"
        @input="filterResults(value)"
      />
    </div>
    <div v-if="filter != '' && value!=''">
          <div v-for="fil of filter" v-bind:key="fil.id" class="legend-card">
        <div class="img-container" v-if="fil.img_url.includes('http')">
          <img v-bind:src="fil.img_url" v-bind:alt="fil.name" />
        </div>
        <div class="img-container" v-else>
          <img
            v-bind:src="
              'http://localhost:8000/legends/get-upload/' + fil.img_url
            "
            v-bind:alt="fil.name"
          />
        </div>
        <div>
          <p><span>Nombre:</span> {{ fil.name }}</p>
        </div>
        <div>
          <p><span>Descripción:</span> {{ fil.description }}</p>
        </div>
        <div>
          <p><span>Provincia de origen:</span> {{ fil.origin_province }}</p>
        </div>
        <div>
          <p><span>Fecha de origen:</span> {{ fil.origin_date }}</p>
        </div>
        <div class="options">
          <button
            @click="clickOnDelete('LegendList', fil.id)"
            title="Eliminar leyenda"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              />
            </svg>
          </button>
          <button
            @click="clickOnChange('UpdateForm', fil.id)"
            title="Actualiza leyenda"
          >
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
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div v-else-if="legends != ''">
      <div v-for="legend of legends" v-bind:key="legend.id" class="legend-card">
        <div class="img-container" v-if="legend.img_url.includes('http')">
          <img v-bind:src="legend.img_url" v-bind:alt="legend.name" />
        </div>
        <div class="img-container" v-else>
          <img
            v-bind:src="
              'http://localhost:8000/legends/get-upload/' + legend.img_url
            "
            v-bind:alt="legend.name"
          />
        </div>
        <div>
          <p><span>Nombre:</span> {{ legend.name }}</p>
        </div>
        <div>
          <p><span>Descripción:</span> {{ legend.description }}</p>
        </div>
        <div>
          <p><span>Provincia de origen:</span> {{ legend.origin_province }}</p>
        </div>
        <div>
          <p><span>Fecha de origen:</span> {{ legend.origin_date }}</p>
        </div>
        <div class="options">
          <button
            @click="clickOnDelete('LegendList', legend.id)"
            title="Eliminar leyenda"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              />
            </svg>
          </button>
          <button
            @click="clickOnChange('UpdateForm', legend.id)"
            title="Actualiza leyenda"
          >
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
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div v-else>
      <h2 class="text-center">No hay leyendas creadas</h2>
    </div>
  </div>
</template>

<script>
export default {
  name: "LegendList",
  data() {
    return {
      value: '',
      legends: [],
      filter: [],
    };
  },
  created() {
    var xhr = new XMLHttpRequest();

    const _this = this;
    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === this.DONE) {
        _this.legends = JSON.parse(this.response).data;
      }
    });

    xhr.open("GET", "http://localhost:8000/api/legends");

    xhr.send();
  },
  methods: {
    filterResults ( value ) {
      this.filter = this.legends.filter(legend => legend.name.toLowerCase().includes(value.toLowerCase()));
    },
    clickOnChange(value, id) {
      this.$emit("clickOnChange", { component: value, legendId: id });
    },
    clickOnDelete(value, id) {
      var xhr = new XMLHttpRequest();

      xhr.addEventListener("readystatechange", function () {
        if (this.readyState === this.DONE) {
          if (this.status != 204) {
            alert("Hubo un error al intentar eliminar.");
          } else {
            location.reload();
          }
        }
      });

      xhr.open("DELETE", "http://localhost:8000/api/legends/" + id);

      xhr.send();

      this.$emit("clickOnChange", { component: value });
    },
  },
};
</script>