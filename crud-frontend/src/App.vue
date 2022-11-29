<template>
  <div>
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">ABC Group Employee List</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>
    <div>
      <button
        type="button"
        class="btn btn-outline-primary"
        data-bs-toggle="modal"
        data-bs-target="#staticBackdrop"
      >
        <i class="bi bi-plus-circle-dotted pe-2"></i>Add Record
      </button>
    </div>
    <div class="table-responsive-md">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">Last name</th>
            <th scope="col">Email</th>
            <th scope="col">phone Number</th>
            <th scope="col">Salary</th>
            <th scope="col">Department</th>
            <th scope="col" colspan="2">Action</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          <tr v-for="(employee, index) in employees" :key="index">
            <td scope="row">{{ index + 1 }}</td>
            <td scope="row">{{ employee.first_name }}</td>
            <td scope="row">{{ employee.last_name }}</td>
            <td scope="row">{{ employee.email }}</td>
            <td scope="row">{{ employee.phone }}</td>
            <td scope="row">{{ employee.salary }}</td>
            <td scope="row">{{ employee.department }}</td>
            <td scope="row">
              <i
                @click="edit(employee)"
                role="button"
                class="bi bi-pen text-success"
                data-bs-toggle="modal"
                data-bs-target="#staticBackdrop"
              ></i>
            </td>
            <td scope="row">
              <i
                role="button"
                class="bi bi-trash text-danger"
                @click="confirmDelete(employee)"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div
      class="modal fade modal-dialog modal-dialog-centered"
      id="staticBackdrop"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">
              {{ isEdit ? "Edit Record" : "Add Record" }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="exampleFormControlInput1" class="form-label"
                  >First Name</label
                >
                <input
                  v-model="form.first_name"
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="Enter first Name"
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                <input
                  v-model="form.last_name"
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="Enter Last Name"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="exampleFormControlInput1" class="form-label"
                  >Email address</label
                >
                <input
                  v-model="form.email"
                  type="email"
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="name@example.com"
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="exampleFormControlInput1" class="form-label"
                  >Phone Number</label
                >
                <input
                  v-model="form.phone"
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="Enter phone Number"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="exampleFormControlInput1" class="form-label">Salary</label>
                <input
                  v-model="form.salary"
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="Enter Salary"
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="exampleFormControlInput1" class="form-label"
                  >Department</label
                >
                <input
                  v-model="form.department"
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="enter department"
                />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Close
            </button>
            <button
              type="button"
              class="btn btn-success"
              @click="save"
              data-bs-dismiss="modal"
            >
              {{ isEdit ? "Update" : "Save" }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DataService from "./service/DataService";
export default {
  name: "add-tutorial",
  data() {
    return {
      employees: [],
      isEdit: false,
      form: {
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
        salary: "",
        department: "",
      },
    };
  },
  created() {
    this.getEmployees();
  },
  methods: {
    async getEmployees() {
      const url = "general/employee";
      try {
        const response = await DataService.getAll(url);
        this.employees = response.data.data;
        console.log(this.employees);
      } catch (e) {
        console.log(e);
      }
    },
    async save() {
      let response = "";
      const url = "general/employee";

      try {
        if (this.isEdit) {
          response = await DataService.update(this.form.id, this.form, url);
          alert("Record Updated Successfully!");
          // this.clearForm();
          // this.getEmployees();
        } else {
          response = await DataService.create(this.form, url);
          // this.clearForm();
          alert("Record Added Successfully!");
          // this.getEmployees();
        }
        this.clearForm();
        this.getEmployees();
      } catch (e) {
        console.log(e);
      }
    },
    edit(data) {
      this.isEdit = true;

      this.form.id = data.id;
      this.form.first_name = data.first_name;
      this.form.last_name = data.last_name;
      this.form.email = data.email;
      this.form.phone = data.phone;
      this.form.salary = data.salary;
      this.form.department = data.department;
    },
    confirmDelete(data) {
      if (confirm("Do you want to delete Record?") == true) {
        // console.log("deleted");
        this.deletePortfolio(data.id);
      } else {
        console.log("not deleted");
      }
    },
    async deletePortfolio(val) {
      const url = "general/employee";
      try {
        const response = await DataService.delete(val, url);
        console.log(response);

        this.getEmployees();
      } catch (e) {
        console.log(e);
      }
    },
    clearForm() {
      this.form = {};
    },
  },
};
</script>

<style scoped></style>
