<template>
  
  <b-alert v-if="errorProduct" variant="danger" show>{{ message }}</b-alert>
  <div v-else>    

    <b-card class="mt-3" :header=product.name>
    <p><strong>Descrição: </strong>{{ product.description }}</p>
    <p><strong>Categoria: </strong>{{ product.category }}</p>
    <p><strong>Preço: </strong>{{ product.price }}</p>

    </b-card>

  </div>
</template>

<script>
export default {
  data() {
    return {
      product: "",
      errorProduct: false,
      message: ""
    };
  },
  props: ["id"],
  methods: {
    getProductHttp() {
      this.$http
        .get(`products/${this.id}`, {
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + this.$store.getters.getToken
          }
        })
        .then(res => {
          if (res.data.status == 404) {
            this.errorProduct = true;
            this.message = res.data.message;
          } else {
            this.product = res.data.data;
          }
        })
        .catch(function(error) {
           /* eslint-disable */
          console.log(error);
        });
    }
  },
  mounted() {
    this.getProductHttp();
  }
};
</script>

<style>
</style>
