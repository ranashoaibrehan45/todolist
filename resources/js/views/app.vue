<template>
    <div class="container">
        <h1>Todo List</h1>
		<button @click="createColumnModal">Add New Column</button>
		
		<div class="row">
			<div class="column" v-for="column in columns">
				<div class="header">
					{{column.title}}
					<span class="remove" @click="removeColumn(column.id)">Remove</span>
				</div>
				<div class="body">
					<button @click="addCardModal(column)" class="btn btn-success">Add Card</button>
					<div class="card" v-if="column.cards" v-for="card in column.cards" @click="viewCard(card)">{{card.title}}</div>
				</div>


			</div>
		</div>
		<addColumn @columnCreated="refreshRecords"></addColumn>
		<addCard :column="column" @cardCreated="getColumns"></addCard>
		<viewCard :card="card"></viewCard>
    </div>
	
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('addColumn', require('./column/addColumn.vue').default);
	Vue.component('addCard', require('./card/addCard.vue').default);
	Vue.component('viewCard', require('./card/cardDetail.vue').default);

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
                    console.log(response.data);
                    console.log(response.data.length);
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
			}
		}// end of methods
	}
</script>