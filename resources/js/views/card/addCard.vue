<template>
    <modal name="addCardModal" class="modal">
        <h1 v-if="column">Add New Card in "{{column.title}}"</h1>
        <div class="form-group">
            <label>Title</label>
            <input v-model="title" />
            <span class="error" v-if="errors.title" v-for="error in errors.title">{{error}}</span>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea v-model="description"></textarea>
            <span class="error" v-if="errors.description" v-for="error in errors.description">{{error}}</span>
            <span class="error"></span>
        </div>

        <div class="modal-footer">
          <button @click="insertCard">Save Changes</button>
          <button @click="hide">Close</button>
        </div>
    </modal>
</template>

<script>
export default {
    props:['column'],
    name: 'addCardModal',
    data() {
      return {
        title: '',
        description: '',
        errors: {}
      }
    },
    methods: {
        insertCard () {
          axios.post("/api/card", {
              column_id: this.column.id,
              title: this.title,
              description: this.description
          })
          .then(response => {
              this.$emit('cardCreated', response);
              this.title = '';
              this.description = '';
          })
          .catch(error => {
              this.errors = error.response.data.errors;
          })
        },
        hide () {
            this.$modal.hide('addCardModal');
        }
    },
    mount () {
        this.show()
    }
}
</script>