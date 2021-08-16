<template>
    <modal name="createColumn" class="modal">
        <h1>Add New Column</h1>
        <div class="form-group">
            <label>Title</label>
            <input v-model="title" />
            <span class="error" v-if="errors.title" v-for="error in errors.title">{{error}}</span>
        </div>
        <div class="modal-footer">
          <button @click="insertColumn">Save Changes</button>
          <button @click="hide">Close</button>
        </div>
    </modal>
</template>

<script>
export default {
    name: 'createColumn',
    data() {
      return {
        title: '',
        errors: {}
      }
    },
    methods: {
        hide () {
            this.$modal.hide('createColumn');
        },
        insertColumn () {
          axios.post("/api/column", {
              title: this.title
          })
          .then(response => {
              console.log("success");
              console.log(response);
              this.$emit('columnCreated', response);
              this.title = '';
          })
          .catch(error => {
              this.errors = error.response.data.errors;
          })
        }
    },
    mount () {
        this.show()
    }
}
</script>