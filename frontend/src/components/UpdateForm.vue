<template>
  <div class="color-white" id="update-form">
    <h2>Editar la leyenda</h2>
    <div class="form-card">
      <div>
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
        <button id="btnOpen" ref="btnOpen" @click="editImg">
          Cambiar imagen
        </button>
        <button class="hide" id="btnClose" ref="btnClose" @click="noEditImg">
          Cancelar
        </button>
      </div>
      <div class="hide" id="imgInputEdit" ref="imgInputEdit">
        <div>
          <label for="img">Seleccione la imagen</label>
          <input type="file" name="image" id="image" ref="image" />
        </div>
        <p>ó</p>
        <div>
          <label for="img">Pegue la URL</label>
          <input type="text" name="img_url" id="img_url" ref="img_url" />
        </div>
      </div>
      <div>
        <label for="name">Nombre</label>
        <input
          type="text"
          name="name"
          id="name"
          ref="name"
          v-bind:value="legend.name"
        />
      </div>
      <div>
        <label for="description">Descripción</label>
        <textarea
          name="description"
          id="description"
          ref="description"
          v-bind:value="legend.description"
          rows="5"
          cols="40"
        ></textarea>
      </div>
      <div>
        <label for="origin_province">Provincia de origen</label>
        <input
          type="text"
          name="origin_province"
          id="origin_province"
          ref="origin_province"
          v-bind:value="legend.origin_province"
        />
      </div>
      <div>
        <label for="origin_date">Fecha de origen</label>
        <input
          type="date"
          name="origin_date"
          id="origin_date"
          ref="origin_date"
          v-bind:value="legend.origin_date"
        />
      </div>
      <div>
        <button @click="clickedOnUpdate">Guardar actualización</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "UpdateForm",
  props: {
    legendId: String,
  },
  data() {
    return {
      legend: [],
    };
  },
  created() {
    var xhr = new XMLHttpRequest();
    const _this = this;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === this.DONE) {
        if (this.status != 200) {
          alert("Hubo un error al intentar eliminar.");
        } else {
          _this.legend = JSON.parse(this.response).data;
        }
      }
    });

    xhr.open("GET", "http://localhost:8000/api/legends/" + this.legendId);

    xhr.send();
  },
  methods: {
    editImg() {
      this.$refs.imgInputEdit.classList.add("show");
      this.$refs.btnClose.classList.add("show");
      this.$refs.btnOpen.classList.add("hide");
    },
    noEditImg() {
      this.$refs.imgInputEdit.classList.remove("show");
      this.$refs.btnClose.classList.remove("show");
      this.$refs.btnOpen.classList.remove("hide");
    },
    clickedOnUpdate() {
      var img_url = this.$refs.img_url;
      var image = this.$refs.image;
      var name = this.$refs.name;
      var description = this.$refs.description;
      var origin_province = this.$refs.origin_province;
      var origin_date = this.$refs.origin_date;

      var xhr = new XMLHttpRequest();
      var url = "http://localhost:8000/api/legends";
      var validated = true;
      const _this = this;

      if (name.value == "") {
        name.classList += "required";
        validated = false;
      }
      if (description.value == "") {
        description.classList += "required";
        validated = false;
      }
      if (origin_province.value == "") {
        origin_province.classList += "required";
        validated = false;
      }
      if (origin_date.value == "") {
        origin_date.classList += "required";
        validated = false;
      }
      if (history.value == "") {
        history.classList += "required";
        validated = false;
      }

      if (img_url.value == "" && image.value == "" && validated) {
        var data = JSON.stringify({
          img_url: this.legend.img_url,
          name: name.value,
          description: description.value,
          origin_province: origin_province.value,
          origin_date: origin_date.value,
        });
        xhr.addEventListener("readystatechange", function () {
          if (this.readyState === this.DONE) {
            if (this.status != 200) {
              alert("Ha ocurrido un error, intentelo de nuevo.");
            } else {
              location.reload();
            }
          }
        });
        xhr.open("PUT", url + "/" + this.legendId);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(data);

      } else if (validated) {
        if (image.value != "") {
          let urlResponse = "";
          let data = new FormData();
          data.append("image", image.files[0]);
          xhr.addEventListener("readystatechange", function () {
            if (this.readyState === this.DONE) {
              if (this.status == 201) {
                urlResponse = JSON.parse(this.response).url;
                var xhr2 = new XMLHttpRequest();
                data = JSON.stringify({
                  img_url: urlResponse,
                  name: name.value,
                  description: description.value,
                  origin_province: origin_province.value,
                  origin_date: origin_date.value,
                });
                xhr2.addEventListener("readystatechange", async function () {
                  if (this.readyState === this.DONE) {
                    if (this.status != 200) {
                      alert("Ha ocurrido un error, intentelo de nuevo.");
                    } else {
                      location.reload();
                    }
                  }
                });
                xhr2.open("PUT", url + "/" + _this.legendId);
                xhr2.setRequestHeader("Content-Type", "application/json");
                xhr2.send(data);
              } else {
                alert(
                  "Ha ocurrido un error al subir la imagen, intentelo de nuevo."
                );
              }
            }
          });
          xhr.open("POST", url + "/upload", true);
          xhr.send(data);
        } else if (
          img_url.value != "" &&
          (img_url.value.includes("http://") ||
            img_url.value.includes("https://"))
        ) {
          let data = JSON.stringify({
            img_url: img_url.value,
            name: name.value,
            description: description.value,
            origin_province: origin_province.value,
            origin_date: origin_date.value,
            history: history.value,
          });
          xhr.addEventListener("readystatechange", function () {
            if (this.readyState === this.DONE) {
              if (this.status != 200) {
                alert("Ha ocurrido un error, intentelo de nuevo.");
              } else {
                location.reload();
              }
            }
          });
          xhr.open("PUT", url + "/" + _this.legendId, true);
          xhr.setRequestHeader("Content-Type", "application/json");
          xhr.send(data);
        } else if (
          !img_url.value.includes("http://") &&
          !img_url.value.includes("https://")
        ) {
          validated = false;
          alert("Ingrese un formato de URL correcto");
        }
      }

      if (validated) this.$emit("clickOnUpdate");
    },
  },
};
</script>

<style>
</style>