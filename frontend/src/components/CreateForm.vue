<template>
  <div id="create-form" class="color-white">
    <h2>Crear la leyenda</h2>
    <div class="form-card">
      <div class="img-input">
        <div >
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
        <input type="text" name="name" id="name" ref="name" />
      </div>
      <div>
        <label for="description">Descripción</label>
        <textarea
          type="text"
          name="description"
          id="description"
          ref="description"
          rows="6"
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
        />
      </div>
      <div>
        <label for="origin_date">Fecha de origen</label>
        <input
          type="date"
          name="origin_date"
          id="origin_date"
          ref="origin_date"
        />
      </div>
      <div>
        <button @click="clickedOnCreate">Crear leyenda</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CreateForm",
  methods: {
    clickedOnCreate() {
      var img_url = this.$refs.img_url;
      var image = this.$refs.image;
      var name = this.$refs.name;
      var description = this.$refs.description;
      var origin_province = this.$refs.origin_province;
      var origin_date = this.$refs.origin_date;

      var xhr = new XMLHttpRequest();
      var url = "http://localhost:8000/api/legends";
      var validated = true;
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

      if (img_url.value == "" && image.value == "") {
        alert("Por favor, elija una imagen o pega una URL externa");
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
                  history: history.value,
                });
                xhr2.addEventListener("readystatechange", async function () {
                  if (this.readyState === this.DONE) {
                    if (this.status != 201) {
                      alert("Ha ocurrido un error, intentelo de nuevo.");
                    } else {
                      location.reload();
                    }
                  }
                });
                xhr2.open("POST", url);
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
              if (this.status != 201) {
                alert("Ha ocurrido un error, intentelo de nuevo.");
              } else {
                location.reload();
              }
            }
          });
          xhr.open("POST", url, true);
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

      if (validated) this.$emit("clickOnCreate");
    },
  },
};
</script>

<style>
</style>