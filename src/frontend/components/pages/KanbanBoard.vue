<template>
     <div id="vue-frontend-app">
       <h1>Boab Kanban Board</h1>

        <div class="container mt-5">

            <div class="row">
                <div class="col form-inline">
                    <b-form-input v-model="newTask" placeholder="Enter Task" @keyup.enter="add"></b-form-input>
                    <b-button class="ml-2" variant="primary" @click="add">Add</b-button>
                </div>
            </div>

             <!-- <div v-for="taskDat in arrInProgress" :key="taskDat.id">
                    {{ taskDat}}
              </div> -->

            <div class="row mt-3">
                
                <div class="col-md-3">
                    <div class="p-2 alert alert-secondary">
                        <h3>Waiting</h3>
                        <draggable class="list-group kanban-column" :list="arrWaiting" group="tasks" @add="onAdd($event, waiting_board_id)" @start="startDrag" @end="endDrag" @change="onChange($event,  waiting_board_id)">
                            <div class="list-group-item" v-for="element in arrWaiting" :key="element.id" :data-id="element.id" :board-id="element.board_id" :order="element.order">
                                {{element.title}} - {{element.order}}
                            </div>
                        </draggable>
                    </div>
                </div>

                <div class="col-md-3">
                        <div class="p-2 alert alert-primary">
                            <h3>In Progress</h3>
                            <draggable class="list-group kanban-column" :list="arrInProgress" group="tasks" @add="onAdd($event, inprogress_board_id)" @start="startDrag" @end="endDrag" @change="onChange($event, inprogress_board_id)">
                                <div class="list-group-item" v-for="element in arrInProgress" :key="element.id" :data-id="element.id" :board-id="element.board_id" :order="element.order">
                                    {{element.title}} - {{element.order}}
                                </div>
                            </draggable>
                        </div>
                </div>

                <div class="col-md-3">
                    <div class="p-2 alert alert-warning">
                        <h3>Ready for Review</h3>
                        <draggable class="list-group kanban-column" :list="arrTested" group="tasks">
                            <div class="list-group-item" v-for="element in arrTested" :key="element.name">
                                {{element.name}}
                            </div>
                        </draggable>
                    </div>
                </div>
            

                <div class="col-md-3">
                 
                    <div class="p-2 alert alert-success">
                        <h3>Done </h3> 
                        <draggable class="list-group kanban-column" :list="arrDone" group="tasks">
                            <div class="list-group-item" v-for="element in arrDone" :key="element.name">
                                {{element.name}}
                            </div>
                        </draggable>
                    </div>
                </div>

                    

            </div>

        </div>
    </div>
</template>

<script>

import draggable from "vuedraggable";
import axios from 'axios'

export default {
    name: 'KanbanBoard',
    components: {
        'draggable': draggable,
    },

    props: ['taskData'],

    data() {
        return {
            newTask: "",
            arrWaiting: taskData.task_waiting,
            arrInProgress: taskData.task_inprogress,
            arrTested: [],
            arrDone: [],
            taskDataOutput: taskData,
            waiting_board_id: 90,
            inprogress_board_id: 91,
            order: ""
        }
    },
    methods: {

        add() {
            if(this.newTask) {
                this.arrBacklog.push({name: this.newTask});
                this.newTask = "";
            }
        },
        onAdd(event, board_id) {
        
            let id = event.item.getAttribute('data-id');
            let order = event.item.getAttribute('order');

            // console.log(id + ' - ' + order);

              //console.log('old: ' + event.oldIndex);
            //console.log('new: ' + event.newIndex);

             //console.log(event.item);

            axios.patch('/boab.aiml.community/wp-json/bkb/v1/tasks/kanban-board-id', {

                task_id:  id,
                board_id: board_id

            } ).then((response) => {
                //console.log(response.data);
            })
         
        },
        startDrag (evt) {
           // console.log('start');
            //console.log({event: event, to: event.to, from: event.from});

            
        },
        endDrag (event) {
        
             //console.log(event.to.children);
            //console.log('old: ' + event.oldIndex);
            //console.log('new: ' + event.newIndex);
           // console.log('loop');
            //console.log('drag');
            //console.log(event.item);
            

            var col_drag = event.item.getAttribute('data-id');
            
            //console.log('list');

            for (var i = 0; i < event.to.children.length; i++) {

                // console.log(event.to.children[i].getAttribute('data-id'));

                 if(col_drag === event.to.children[i].getAttribute('data-id')) {

                        if(event.to.children[i + 1] != "") {

                            var down_d = event.to.children[i + 1];

                        } else if(event.to.children[i - 1] != "") {

                            var down_d = event.to.children[i + 1];

                        } else if(event.to.children[i + 1] != "") {

                            var down_d = event.to.children[i - 1];

                        } 
                        
                        if(event.to.children[i + 1] == undefined) {

                           var down_d = event.to.children[i - 1];

                        }

                        if(event.to.children[i + 1] != undefined || event.to.children[i - 1] != undefined) {

                            let d_order = parseInt(down_d.getAttribute('order')) ;
                        
                         
                            let sum_order_add = d_order + 1;
                            let sum_order_minus = d_order - 1;

                            let order_update_db;

                            if(event.to.children[i + 1] == undefined) {

                                 //console.log( d_order + ' - ' + sum_order_add)

                                 order_update_db =  sum_order_add;

                             } else if(event.to.children[i - 1] == undefined) {

                                 //console.log( d_order + ' - ' + sum_order_minus)

                                    order_update_db =  sum_order_minus;

                             } else {

                                 //console.log( d_order + ' - ' + sum_order_minus)

                                  order_update_db =  sum_order_minus;

                             }
                                console.log(col_drag)
                                console.log(order_update_db)

                            axios.patch('/boab.aiml.community/wp-json/bkb/v1/tasks/kanban-board-order-col', {

                                order_update_db: order_update_db,
                                data_id: col_drag 

                            } ).then((response) => {

                            // console.log(response.data);

                            })

                            //console.log(sum_order_add + ' - ' + sum_order_minus)

                        }

                        
                         
                  
                
                        
                        
                 }

         
          


                if(event.item == event.to.children[i]) {
                         
                    var current = event.to.children[i];

                   

                    if(event.oldIndex > event.newIndex) {
                        var down = event.to.children[i + 1];
                    } else {
                         var down = event.to.children[i - 1];
                    }
                   
                    
                    //console.log( down );
                    // console.log(current.getAttribute('order'));
                    // console.log('down');
                    // console.log(down.getAttribute('order'));

                    var current_order = current.getAttribute('order');
                    var current_id = current.getAttribute('data-id');

                    var down_order = down.getAttribute('order');
                    var down_id = down.getAttribute('data-id');


                    //console.log('current: ' + current_id + ' ' + current_order);
                    //console.log('down: ' + down_id + ' ' + down_order);
                    

                    if(down != undefined) {

                        axios.patch('/boab.aiml.community/wp-json/bkb/v1/tasks/kanban-board-order', {

                            current_order:  current_order,
                            current_id: current_id,
                            down_order: down_order,
                            down_id: down_id

                        } ).then((response) => {

                           // console.log(response.data);

                        })

                    }

                }
            }
       
        },
        onChange (event, col) {

            this.arrInProgress.map((progress, index) => {
                    //progress.order = index + 1;
                    //console.log(progress.title);
            })
           

              //console.log(event.to)
       
        }
    },
    mounted() {
        //this.onAdd()
    }
}
</script>

<style>

.kanban-column {
    min-height: 300px;
}

</style>