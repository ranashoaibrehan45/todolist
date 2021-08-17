<template>
    <div class="container">
        <h1>Todo List</h1>
		<button @click="createColumnModal" class="btn btn-primary">Add New Column</button>
		
		<div class="row">
			<div class="column" v-for="(column, CI) in columns">
				<div class="header">
					{{column.title}}
					<button class="remove" @click="removeColumn(column.id)">Remove</button>
				</div>
				<div class="body">
					<button @click="addCardModal(column)" class="btn btn-success pull-right mt-1 mb-1 mr-1">Add Card</button>
					<br class="clear">
					<div class="card" v-if="column.cards" v-for="(card, RI) in column.cards">
						<div class="title" @click="viewCard(card)">{{card.title}}</div>
						<div class="button-group">
							<button v-if="RI !== 0" @click="updateCardPosition(column.id, card.id, 'up')">&#8593;</button>
							<button v-if="CI !== columns.length-1" @click="updateCardPosition(column.id, card.id, 'right')">&#8594;</button>
							<button v-if="RI !== column.cards.length - 1" @click="updateCardPosition(column.id, card.id, 'down')">&#8595;</button>
							<button v-if="CI !== 0" @click="updateCardPosition(column.id, card.id, 'left')">&#8592;</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<addColumn @columnCreated="refreshRecords"></addColumn>
		<addCard :column="column" @cardCreated="getColumns"></addCard>
		<viewCard :card="card" @cardEdited="editCard"></viewCard>
    	<editCard :card="card" @cardUpdated="getColumns"></editCard>
    </div>
	
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('addColumn', require('./column/addColumn.vue').default);
	Vue.component('addCard', require('./card/addCard.vue').default);
	Vue.component('viewCard', require('./card/cardDetail.vue').default);
	Vue.component('editCard', require('./card/editCard.vue').default);

	export default{
		data() {
			return {
				columns:{},
				column:{},
				card:{},
                isModalVisible: false,
			}
		},
		created() {
			this.getColumns()
		}, // end of created

		methods: {
			getColumns() {
				axios.get('api/column')
				.then(response => {
                    if(response.data.length > 0)
					{
						this.columns = response.data;
					}
				})
				.catch(error=>{
					console.log(error)
				});
			},
			removeColumn(id) {
				if(confirm("Really mean to delete this column."))
				{
					axios.post("api/column/" + id,{
						'id': id,
						'_method': 'DELETE'
					})
					.then(response => {
						this.columns = response.data;
					})
					.catch(error => this.errors = error.response.data.errors)
				}
			},
			createColumnModal() {
				this.$modal.show('createColumn')
			},
			refreshRecords(columns) {
				this.columns = columns.data;
			},
			addCardModal(column) {
				this.column = column;
				this.$modal.show('addCardModal');
			},
			viewCard(card) {
				this.card = card;
				this.$modal.show('cardDetailModal');
			},
			editCard() {
				console.log('editCardModal');
				this.$modal.show('editCardModal');
			},
			updateCardPosition(columnId, cardId, move) {
				axios.post("api/column/sort/cards",{
					'column_id': columnId,
					'card_id': cardId,
					'move': move
				})
				.then(response => {
					this.columns = response.data;
				})
				.catch(error => this.errors = error.response.data.errors)
			},
		}// end of methods
	}
</script>