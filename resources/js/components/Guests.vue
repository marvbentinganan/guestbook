<template>
    <div>
    <div class="text-center p-10">
        <h1>Guests</h1>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <th class="text-center align-middle">Firstname</th>
            <th class="text-center align-middle">Lastname</th>
            <th class="text-center align-middle">Email</th>
            <th class="text-center align-middle">Phone Number</th>
            <th class="text-center align-middle">Gender</th>
            <th class="text-center align-middle">Address</th>
            <th class="text-center align-middle" style="width:150px;">
                <button class="btn btn-primary btn-sm" @click="showAddModal()">Add Guest</button>
            </th>
        </thead>
        <tbody>
            <tr v-if="!guests.length">
                <td class="text-center" colspan="7">No Guests Found</td>
            </tr>
            <tr v-else v-for="guest in guests" :key="guest.id">
                <td>{{ guest.first_name }}</td>
                <td>{{ guest.last_name }}</td>
                <td>{{ guest.email }}</td>
                <td class="text-center">{{ guest.phone_number }}</td>
                <td class="text-center">{{ guest.gender }}</td>
                <td>{{ guest.address }}</td>
                <td>
                    <button class="btn btn-primary btn-sm" @click="showUpdateModal(guest)">Update</button>
                    <button class="btn btn-danger btn-sm" @click="deleteGuest(guest.id)">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Add Guest Modal -->
    <div class="modal fade" id="addGuest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <add-guest></add-guest>
        </div>
    </div>

    <!-- Update Guest Modal -->
    <div class="modal fade" id="updateGuest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="updateGuest()" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Guest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">Firstname</label>
                            <input type="text" name="first_name" class="form-control" id="first_name" v-model="guest_data.first_name" placeholder="Firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Lastname</label>
                            <input type="text" name="last_name" class="form-control" id="last_name" v-model="guest_data.last_name" placeholder="Lastname">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" v-model="guest_data.email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone_number">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control" id="phone_number" v-model="guest_data.phone_number" placeholder="Phone Number">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control" v-model="guest_data.gender">
                                <option v-for="option in options" :key="option.value">{{ option.label }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="5" v-model="guest_data.address"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Update Guest</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
    export default {
        name: "guests-list",
        data() {
            return {
                guests: {},
                guest_data : {
                    first_name : "",
                    last_name : "",
                    email : "",
                    phone_number : "",
                    gender : "",
                    address : ""
                },

                options: [
                    {value : "male", label: "Male"},
                    {value : "female", label: "Female"}
                ],

                update_route : "",
            }
        },
        mounted() {
            this.getGuests();
            this.$root.$on('get-guests', this.getGuests)
        },
        methods : {
            getGuests(){
                axios.get(route('guest.list'))
                .then(response => {
                    this.guests = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            },

            updateGuest(){
                axios.patch(this.update_route, this.$data.guest_data)
                .then(response => {
                    this.getGuests();
                    $('#updateGuest').modal('hide');
                    Swal.fire("Success!", "Guest Updated", 'info');
                })
                .catch(error => {
                    console.log(error);
                });
            },

            clearForm(){
              this.guest_data.first_name = null;
              this.guest_data.last_name = null;
              this.guest_data.email = null;
              this.guest_data.phone_number = null;
              this.guest_data.gender = null;
              this.guest_data.address = null;  
            },

            showAddModal(){
                $('#addGuest').modal('show');
            },

            showUpdateModal(guest){
                this.guest_data = guest;
                $('#updateGuest').modal('show');
                this.update_route = route('guest.update', [guest.id, 'frontend']);
            },

            deleteGuest(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: 'This will delete guest data',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, delete it!',
                    html: false,
                    showLoaderOnConfirm: true,
                }).then(result => {
                    if (result.value) {
                        axios.delete(route('guest.delete', id))
                            .then(response => {
                                swal.fire('Deleted', response.data, 'success');
                                this.getGuests();
                            });
                    }
                })
            }
        }
    }
</script>
