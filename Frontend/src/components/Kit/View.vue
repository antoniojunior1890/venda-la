<template>
  <b-alert v-if="errorKit" variant="danger" show>{{ message }}</b-alert>
  <div v-else>
    <b-card class="mt-3" :header=kit.name>
      <pre>Valor: R$ {{ kit.price }}</pre>
      <b-card-body>
        <b-table striped hover :items="kit.products" :fields="fields"></b-table>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      kit: "",
      errorKit: false,
      message: "",
      fields: [
        { id: "#" },
        { name: "Nome" },
        { description: "Descrição" },
        { price: "Preço" }
      ]
    };
  },
  props: ["id"],
  methods: {
    getKitHttp() {
      this.$http
        .get(`kits/${this.id}`, {
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
            this.kit = res.data.data;
          }
        })
        .catch(function(error) {
           /* eslint-disable */
          console.log(error);
        });
    }
  },
  mounted() {
    this.getKitHttp();
  }
};
</script>

<style>
</style>
