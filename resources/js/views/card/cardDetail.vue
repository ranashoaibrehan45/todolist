<template>
    <modal name="cardDetailModal" class="modal">
        <h1 v-if="card">{{card.title}}</h1>
        <p>{{card.description}}</p>

        <div class="modal-footer">
          <button @click="hide">Close</button>
        </div>
    </modal>
</template>

<script>
export default {
    props:['card'],
    name: 'cardDetailModal',
    data() {
      return {
        title: '',
        description: '',
        errors: {}
      }
    },
    methods: {
        hide () {
            this.$modal.hide('cardDetailModal');
        }
    },
    mount () {
        this.show()
    }
}
</script>