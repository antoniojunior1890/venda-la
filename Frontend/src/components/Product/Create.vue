<template>
  <div>
    <b-alert
      v-for="(message, index) in messageInfo"
      :key="index"
      variant="primary"
      dismissible
      show
    >{{ message }}</b-alert>
    <b-card class="mt-3" header="Criar Produto">
      <b-card-body>
        <b-form >
          <b-form-group  id="input-group-2" label="Nome:" label-for="input-2">
            <b-form-input id="input-2" v-model="product.name" required placeholder="Nome"></b-form-input>
          </b-form-group>
          <b-form-group id="input-group-2" label="Descrição:" label-for="input-2">
            <b-form-input
              id="input-2"
              v-model="product.description"
              required
              placeholder="Descrição"
            ></b-form-input>
          </b-form-group>
          <b-form-group id="input-group-2" label="Categoria:" label-for="input-2">
            <b-form-select id="input-3" v-model="product.category" :options="categories" required></b-form-select>
          </b-form-group>
          <b-form-group id="input-group-2" label="Preço:" label-for="input-2">
            <b-form-input id="input-2" v-model.number="product.price" required placeholder="Preço"></b-form-input>
          </b-form-group>
          <b-form-file  v-model="file" class="mt-3" plain></b-form-file>
            <div class="mt-3">Arquivo selecionado: {{ file ? file.name : '' }}</div>

          <b-button class="mt-3" @click="sendProduct" variant="primary">Salvar</b-button>
        </b-form>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      file: null,
      image: '',
      product: {
        name: "",
        description: "",
        category: "",
        price: 0,
        image: "d"
      },
      messageInfo: [],
      categories: []
    };
  },
  created() {
    axios
      .get("https://api.mercadolibre.com/sites/MLA/categories")
      .then(res => {
        res.data.map(item => {
          this.categories.push({ value: item.id, text: item.name });
        });
      })
      .catch(function(error) {
         /* eslint-disable */
        console.log(error);
      });
  },
  methods: {
    onImageChange(event){
      this.image = event.target.files[0];
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    sendProduct() {
      const formData = new FormData()
      formData.append('image', this.file);
      formData.append('product', JSON.stringify(this.product));

      this.$http
        .post("products", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.$store.getters.getToken
          }
        })
        .then(res => {
          res.data.map(item => {
            this.messageInfo.push(item.data.msg);
          });
          this.product = {};
          this.file = []
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>

<style>
</style>
