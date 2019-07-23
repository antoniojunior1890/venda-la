<template>
  <div>
    <b-button class="mt-3" to="/kit/create" variant="info">Novo</b-button>
    <b-alert v-if="errorKits" variant="danger" show>{{ message }}</b-alert>
    <div v-else>
      <b-card class="mt-3" header="Kits">
        <b-card-body>
          <b-table striped hover :items="items" :fields="fields">
              <template slot="view" slot-scope="row">
                <b-button size="sm" variant="success" @click="viewKit(row)" class="mr-2">
                  visualizar
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
      fields: [{ id: "Cod" }, { name: "Nome" }, { price: "Preço" },{view: "Visualizar" }],
      items: [],
      errorKits: false,
      message: ""
    };
  },
  methods: {
    viewKit(row){
      this.$router.push({ path: `kit/view/${row.item.id}`})
    }
  },
  mounted() {
    this.$http
      .get("kits", {
        headers: {
          "Content-Type": "application/json",
          Authorization: "Bearer " + this.$store.getters.getToken
        }
      })
      .then(res => {
        if (res.data.status == 401) {
          this.errorProducts = true;
          this.message = res.data.message;
        } else {
          this.items = res.data.data;
        }
      })
      .catch(function(error) {
         /* eslint-disable */
        console.log(error);
      });
  }
};
</script>

<style>
</style>
