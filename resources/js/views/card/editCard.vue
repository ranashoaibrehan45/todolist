<template>
    <modal name="editCardModal" class="modal">
        <h1>Update Card</h1>
        <div class="form-group">
            <label>Title</label>
            <input v-model="card.title" />
            <span class="error" v-if="errors.title" v-for="error in errors.title">{{error}}</span>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea v-model="card.description"></textarea>
            <span class="error" v-if="errors.description" v-for="error in errors.description">{{error}}</span>
            <span class="error"></span>
        </div>

        <div class="modal-footer">
          <button @click="updateCard">Save Changes</button>
          <button @click="hide">Close</button>
        </div>
    </modal>
</template>

<script>
export default {
    props:['card'],
    name: 'editCardModal',
    data() {
      return {
        errors: {}
      }
    },
    methods: {
        updateCard () {
          axios.post("/api/card/" + this.card.id, {
              _method: 'PUT',
              title: this.card.title,
              description: this.card.description
          })
          .then(response => {
              this.$emit('cardUpdated');
              this.$modal.hide('editCardModal');
          })
          .catch(error => {
              this.errors = error.response.data.errors;
          })
        },
        hide () {
            this.$modal.hide('editCardModal');
        }
    },
    mount () {
        this.show()
    }
}
</script>