<template>
  <div>
    <b-alert
      v-for="(message, index) in messageInfo"
      :key="index"
      variant="success"
      dismissible
      show
    >{{ message }}</b-alert>
    <b-button class="mt-3" to="/product/create" variant="info">Novo</b-button>
    <b-alert v-if="errorProducts" variant="danger" show>{{ message }}</b-alert>
    <div v-else>
      <b-card class="mt-3" header="Produtos">
        <b-card-body>
          <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
          ></b-pagination>
          <b-table
            striped
            hover
            :items="items"
            :fields="fields">
              <template slot="view" slot-scope="row">
                <b-button size="sm" :to="`/product/view/${row.item.id}`" variant="success" class="mr-2">
                  visualizar
                </b-button>
              </template>
              <template slot="delete" slot-scope="row">
                <b-button size="sm" @click="deleteProduct(row)" variant="danger" class="mr-2">
                  deletar
                </b-button>
              </template>
          </b-table>
        </b-card-body>
      </b-card>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      perPage: 5,
      currentPage: 1,
      totalItems: 0,
      fields: [{id: "ID"}, { name: "Nome" }, { price: "Preco" },
        { category: "Categoria" }, {view: "Visualizar" }, {delete: "Apagar" }],
      items: [],
      errorProducts: false,
      message: "",
      messageInfo: [],
    };
  },
  computed: {
    rows() {
      return this.totalItems;
    }
  },

  methods: {
    deleteProduct({ item }){
      // console.log(item.id)
      this.$http
        .delete(`products/${item.id}`, {
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + this.$store.getters.getToken
          }
        })
        .then(res => {
          if(res.status === 200)
          {
            this.getProducts()
            res.data.map(item => {
              this.messageInfo.push(item.data.msg);
            });
          }
        })
        .catch(function(error) {
           /* eslint-disable */
          console.log(error);
        });
    },
    getProducts() {
      this.$http
        .get(`products?page=${this.currentPage}`, {
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + this.$store.getters.getToken
          }
        })
        .then(res => {
          if (res.data.status == 401){
            this.errorProducts = true;
            this.message = res.data.message;
          }
          else{
            this.items = res.data.data.data;
            this.totalItems = res.data.data.total
          }
        })
        .catch(function(error) {
           /* eslint-disable */
          console.log(error);
        });
    }
  },
  watch: {
    currentPage: function () {
      this.getProducts()
    }
  },
  mounted() {
    this.getProducts()
  }
};
</script>

<style>
</style>
