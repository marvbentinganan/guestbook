<template>
  <form @submit.prevent="addGuest()" class="modal-content">
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
          <input
            type="text"
            name="first_name"
            class="form-control"
            id="first_name"
            v-model="guest.first_name"
            placeholder="Firstname"
          >
        </div>
        <div class="form-group col-md-6">
          <label for="last_name">Lastname</label>
          <input
            type="text"
            name="last_name"
            class="form-control"
            id="last_name"
            v-model="guest.last_name"
            placeholder="Lastname"
          >
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="email">Email</label>
          <input
            type="email"
            name="email"
            class="form-control"
            id="email"
            v-model="guest.email"
            placeholder="Email"
          >
        </div>
        <div class="form-group col-md-4">
          <label for="phone_number">Phone Number</label>
          <input
            type="tel"
            name="phone_number"
            class="form-control"
            id="phone_number"
            v-model="guest.phone_number"
            placeholder="Phone Number"
          >
        </div>
        <div class="form-group col-md-4">
          <label for="gender">Gender</label>
          <select id="gender" name="gender" class="form-control" v-model="guest.gender">
            <option v-for="option in options" :key="option.value">{{ option.label }}</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="address">Address</label>
          <textarea
            class="form-control"
            name="address"
            id="address"
            rows="5"
            v-model="guest.address"
          ></textarea>
        </div>
      </div>
      <span v-if="errors.length">
        <div
          class="alert alert-danger"
          role="alert"
          v-for="error in errors"
          :key="error"
        >{{ error }}</div>
      </span>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Add Guest</button>
    </div>
  </form>
</template>

<script>
import Swal from "sweetalert2";
export default {
  name: "add-guest",
  data() {
    return {
      guest: {
        first_name: "",
        last_name: "",
        email: "",
        phone_number: "",
        gender: "",
        address: ""
      },
      options: [
        { value: "male", label: "Male" },
        { value: "female", label: "Female" }
      ],

      errors: [],
      valid: false
    };
  },
  mounted() {},
  methods: {
    addGuest() {
      if (this.validateForm() == true) {
        axios
          .post(route("guest.store", "frontend"), this.$data.guest)
          .then(response => {
            this.clearForm();
            this.$root.$emit("get-guests");
            $("#addGuest").modal("hide");
            Swal.fire("Success!", "Guest Added", "success");
          })
          .catch(error => {
              this.errors = error.response.data.errors;
            console.log(error);
          });
      }
    },

    validateForm() {
      if (
        this.guest.first_name &&
        this.guest.last_name &&
        this.guest.email &&
        this.guest.phone_number &&
        this.guest.gender &&
        this.guest.address
      ) {
        return true;
      }

      this.errors = [];

      if (!this.guest.first_name) {
        this.errors.push("Firstname is required!");
      }

      if (!this.guest.last_name) {
        this.errors.push("Lastname is required!");
      }

      if (!this.guest.email) {
        this.errors.push("Email is required!");
      }

      if (!this.guest.phone_number) {
        this.errors.push("Phone Number is required!");
      }

      if (!this.guest.gender) {
        this.errors.push("Gender is required!");
      }

      if (!this.guest.address) {
        this.errors.push("Address is required!");
      }
    },

    clearForm() {
      this.guest.first_name = null;
      this.guest.last_name = null;
      this.guest.email = null;
      this.guest.phone_number = null;
      this.guest.gender = null;
      this.guest.address = null;
    }
  }
};
</script>
