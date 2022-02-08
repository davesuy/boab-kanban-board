<template>
     <div id="vue-frontend-app">
       <!-- <h1>Boab Kanban Board</h1> -->

    

        <div class="container mt-5">
<!-- 
            <p>Title: {{ newTaskWaiting }}</p>
            <p>Selected: {{ selected }}</p>
            <p>Due Date: {{ due_date }}</p>
            <p>KanBoard ID: {{ waiting_board_id }}</p>
            <p>Tasklist ID: {{ waiting_task_list_board_id }}</p> -->
                        
<!-- 
            <div class="row">
                <div class="col form-inline">
                    <b-form-input v-model="newTaskWaiting" placeholder="Enter Task" @keyup.enter="add"></b-form-input>
                    <b-button class="ml-2" variant="primary" @click="add">Add</b-button>
                </div>
            </div> -->

             <!-- <div v-for="taskDat in arrInProgress" :key="taskDat.id">
                    {{ taskDat.title }}
              </div> -->

            <div class="row mt-3">
                
                <div class="col-md-3">

                    <div class="p-2 alert alert-secondary">

                        <h4 class="text-center">Waiting</h4>

                        <draggable class="list-group kanban-column" :list="arrWaiting" group="tasks" @add="onAdd($event, waiting_board_id)" @start="startDrag" @end="endDrag" @change="onChange($event,  waiting_board_id)">
                            
                            <div class="list-group-item" v-for="element in arrWaiting" :key="element.id" :data-id="element.id" :board-id="element.board_id" :order="element.order">
                               
                               <h6> {{element.title}} <span v-show="hide == false"> - {{element.order}} </span> </h6>
                               <p> {{element.description}} </p>
                            
                            </div>

                        </draggable>

                    </div>

                    <b-form @submit="onSubmit($event, waiting_board_id, waiting_task_list_board_id)">

                        <div class="row mt-3 mb-3 ">

                            <div class="col-md-8 pr-0">
                                <b-form-input id="link-button-waiting" v-model="newTaskWaiting" placeholder="Enter Task" @keyup.enter="add"></b-form-input>                          
                            </div>

                            <b-popover target="link-button-waiting" triggers="focus" placement="left">
  
                                <p><b-form-select v-model="selected" :options="options"></b-form-select></p>
                                <p><b-form-datepicker id="due-date-datepicker" v-model="due_date" class="mb-2"></b-form-datepicker></p>
                         
                            </b-popover>


                            <div class="col-md-4 pl-0 pt-1">
                            
                                <b-button type="submit" class="ml-2" variant="primary">Add</b-button>

                            </div>

                        </div>      

                    </b-form>


                </div>

                <div class="col-md-3">
                
                    <div class="p-2 alert alert-primary">
                        <h4 class="text-center">In Progress</h4>
                        <draggable class="list-group kanban-column" :list="arrInProgress" group="tasks" @add="onAdd($event, inprogress_board_id)" @start="startDrag" @end="endDrag" @change="onChange($event, inprogress_board_id)">
                            <div class="list-group-item" v-for="element in arrInProgress" :key="element.id" :data-id="element.id" :board-id="element.board_id" :order="element.order">
                                <h6> {{element.title}} <span v-show="hide == false">- {{element.order}} </span> </h6>
                                <p> {{element.description}} </p>
                            </div>
                        </draggable>
                    </div>

                    <b-form @submit="onSubmit($event, inprogress_board_id, inprogress_task_list_board_id)">

                        <div class="row mt-3 mb-3 ">

                            <div class="col-md-8 pr-0">
                                
                                <b-form-input id="link-button-inprogress" v-model="newTaskInprogress" placeholder="Enter Task" @keyup.enter="add"></b-form-input>
                           
                            </div>

                            <b-popover target="link-button-inprogress" triggers="focus" placement="left">
  
                                <p><b-form-select v-model="selected" :options="options"></b-form-select></p>
                                <p><b-form-datepicker id="due-date-datepicker" v-model="due_date" class="mb-2"></b-form-datepicker></p>
                         
                            </b-popover>


                            <div class="col-md-4 pl-0 pt-1">
                            
                                <b-button type="submit" class="ml-2" variant="primary">Add</b-button>

                            </div>

                        </div>      

                    </b-form>

                </div>

                <div class="col-md-3">

                   <div class="p-2 alert alert-secondary">

                        <h4 class="text-center">Ready for Review</h4>

                        <draggable class="list-group kanban-column" :list="arrReady" group="tasks" @add="onAdd($event, ready_board_id)" @start="startDrag" @end="endDrag" @change="onChange($event,  ready_board_id)">
                            
                            <div class="list-group-item" v-for="element in arrReady" :key="element.id" :data-id="element.id" :board-id="element.board_id" :order="element.order">
                               
                               <h6> {{element.title}} <span v-show="hide == false"> - {{element.order}} </span> </h6>
                               <p> {{element.description}} </p>
                            
                            </div>

                        </draggable>

                    </div>

                    
                    <b-form @submit="onSubmit($event, ready_board_id, ready_task_list_board_id)">

                        <div class="row mt-3 mb-3 ">

                            <div class="col-md-8 pr-0">
                                <b-form-input id="link-button" v-model="newTaskReady" placeholder="Enter Task" @keyup.enter="add"></b-form-input>          
                            </div>

                            <b-popover target="link-button" triggers="focus" placement="bottom">
  
                                <p><b-form-select v-model="selected" :options="options"></b-form-select></p>
                                <p><b-form-datepicker id="due-date-datepicker" v-model="due_date" class="mb-2"></b-form-datepicker></p>
                         
                            </b-popover>


                            <div class="col-md-4 pl-0 pt-1">
                            
                                <b-button type="submit" class="ml-2" variant="primary">Add</b-button>

                            </div>

                        </div>      

                    </b-form>

                </div>
            

                <div class="col-md-3">

                   <div class="p-2 alert alert-success">

                        <h4 class="text-center">Done</h4>

                        <draggable class="list-group kanban-column" :list="arrDone" group="tasks" @add="onAdd($event, done_board_id)" @start="startDrag" @end="endDrag" @change="onChange($event,  done_board_id)">
                            
                            <div class="list-group-item" v-for="element in arrDone" :key="element.id" :data-id="element.id" :board-id="element.board_id" :order="element.order">
                               
                               <h6> {{element.title}} <span v-show="hide == false"> - {{element.order}} </span> </h6>
                               <p> {{element.description}} </p>
                            
                            </div>

                        </draggable>

                    </div>

                    
                    <b-form @submit="onSubmit($event, done_board_id, done_task_list_board_id)">

                        <div class="row mt-3 mb-3 ">

                            <div class="col-md-8 pr-0">
                                <b-form-input id="link-button" v-model="newTaskDone" placeholder="Enter Task" @keyup.enter="add"></b-form-input>
                                <b-form-input v-model="done_board_id" type="text" v-if="false"></b-form-input>
                                <b-form-input v-model="done_task_list_board_id" type="text" v-if="false"></b-form-input>
                            </div>

                            <b-popover target="link-button" triggers="focus" placement="bottom">
  
                                <p><b-form-select v-model="selected" :options="options"></b-form-select></p>
                                <p><b-form-datepicker id="due-date-datepicker" v-model="due_date" class="mb-2"></b-form-datepicker></p>
                         
                            </b-popover>


                            <div class="col-md-4 pl-0 pt-1">
                            
                                <b-button type="submit" class="ml-2" variant="primary">Add</b-button>

                            </div>

                        </div>      

                    </b-form>

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
            newTaskWaiting: "",
            newTaskInprogress: "",   
            newTaskReady: "",  
            newTaskDone: "",  
            arrWaiting: taskData.task_waiting,
            arrInProgress: taskData.task_inprogress,
            arrReady: taskData.task_ready,
            arrDone: taskData.task_done,
            taskDataOutput: taskData,
            waiting_board_id: taskData.board_id_waiting,
            waiting_task_list_board_id: taskData.board_id_waiting_task_list,
            inprogress_board_id: taskData.board_id_inprogress,
            inprogress_task_list_board_id: taskData.board_id_inprogress_task_list,
            ready_board_id: taskData.board_id_ready,
            ready_task_list_board_id: taskData.board_id_ready_task_list,
            done_board_id: taskData.board_id_done,
            done_task_list_board_id: taskData.board_id_done_task_list,
            order: "",
            hide: true,
            selected: null,
            options: [
            { value: null, text: 'Select User' },
            { value: '2', text: 'Test User' },
            { value: '4', text: 'Dave Ramirez' }
            ],
            due_date: ""
        }
    },
    onSubmitData(col_data, col_arr) {

        
            if(col_data) {

                col_arr.push({title: col_data, board_id: this.waiting_board_id, id: ""});

                axios.post('/boab.aiml.community/wp-json/bkb/v1/tasks/kanban-board-add', {

                    title: col_data,
                    user: this.selected,
                    due_date: this.due_date,
                    board_id: board_id,
                    board_task_id: board_task_id
                  
                } ).then((response) => {

                    console.log(response.data);

                    //console.log(this.arrWaiting.length - 1);

                    let arr_count = col_arr.length - 1;

                   col_arr.forEach(function(part, index, theArray) {
                         // console.log(part.id);
                         //console.log(theArray.board_id);
                     

                          if(index == arr_count ) {
                            //console.log(index + 'gana');
                              part.id = response.data;
                          }
                    },  col_arr);



                })

                
                col_data = "";
                this.due_date = "";
                this.selected = null;
                this.options = this.options;

            }

    },
    methods: {

        onSubmit(evt, board_id, board_task_id) {

            console.log(board_id);
            console.log(board_task_id);

            evt.preventDefault();

            this.onSubmitData(this.newTaskWaiting,this.arrWaiting);

        },
        addInprogress() {
            if(this.newTaskInprogress) {
                this.arrInProgress.push({title: this.newTaskInprogress});
                this.newTaskInprogress = "";
            }
        },
        onAdd(event, board_id) {
        
            let id = event.item.getAttribute('data-id');
            let order = event.item.getAttribute('order');

           // console.log(id + ' - board_id: ' + board_id + '- order: ' + order);

              //console.log('old: ' + event.oldIndex);
            //console.log('new: ' + event.newIndex);

             //console.log(event.item);

            axios.patch('/boab.aiml.community/wp-json/bkb/v1/tasks/kanban-board-id', {

                task_id:  id,
                board_id: board_id

            } ).then((response) => {
               console.log(response.data);
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
                               // console.log(col_drag)
                                //console.log(order_update_db)

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

          //console.log(this.arrWaiting)
    }
}
</script>

<style>

.kanban-column {
    overflow: hidden;
    height: 600px;
    overflow-y: scroll;
}

</style>