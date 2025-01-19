<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR10</title>
    <script src="/assets/js/vue.js"></script>
    <script src="/assets/js/axios.min.js"></script>
</head>
<body>
    <div id="app">
        <div>
            <form @submit.prevent="addStudent">
                <input type="text" v-model="newItem.name" placeholder="Name" required>
                <select v-model="newItem.group_id" required>
                    <option value="">Select Group</option>
                    <option v-for="g in groups" :value="g.id">{{ g.name }}</option>
                </select>
                <button type="submit">Add Student</button>
            </form>
            <p>{{ msg }}</p>
        </div>

        <table v-if="students">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Group</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            <tr v-for="s in students" :key="s.id">
                <td>{{ s.id }}</td>
                <td><input v-model="s.name"></td>
                <td>
                    <select v-model="s.group_id">
                        <option v-for="g in groups" :value="g.id">{{ g.name }}</option>
                    </select>
                </td>
                <td><button @click="updateStudent(s)">Update</button></td>
                <td><button @click="deleteStudent(s.id)">Delete</button></td>
            </tr>
        </table>
    </div>

    <script>
    new Vue({
        el: "#app",
        data: {
            students: [],
            groups: [],
            newItem: { name: '', group_id: '' },
            msg: ''
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                axios.get('/index.php/students/getData')
                    .then(response => {
                        this.students = response.data.students;
                        this.groups = response.data.groups;
                    })
                    .catch(error => console.error(error));
            },
            addStudent() {
                axios.post('/index.php/students/addStudent', this.newItem)
                    .then(response => {
                        if (response.data) {
                            this.msg = 'Student added successfully!';
                            this.getData();
                        }
                    })
                    .catch(error => console.error(error));
            },
            updateStudent(student) {
                axios.post('/index.php/students/actions', {
                    id: student.id,
                    name: student.name,
                    group_id: student.group_id,
                    update: true
                }).then(response => {
                    if (response.data) {
                        this.msg = 'Student updated successfully!';
                    }
                }).catch(error => console.error(error));
            },
            deleteStudent(id) {
                axios.post('/index.php/students/actions', {
                    id: id,
                    delete: true
                }).then(response => {
                    if (response.data) {
                        this.msg = 'Student deleted successfully!';
                        this.getData();
                    }
                }).catch(error => console.error(error));
            }
        }
    });
    </script>
</body>
</html>
