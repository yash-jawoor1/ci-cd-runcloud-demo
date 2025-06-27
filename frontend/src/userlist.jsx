import React, { useState } from 'react';
import axios from 'axios'

function UserList(props) {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState(null)

  const fetchUsers = () => {
    setLoading(true)
    axios.get('https://jsonplaceholder.typicode.com/users')
      .then((res) => {
        setUsers(res.data)
        setLoading(false)
      })
      .catch((err) => {
        console.log("error occurred")
        setError(err)
      })
  }

  const onClick = () => {
    fetchUsers()
  }

  return (
    <div>
      <h1>Users</h1>
      <button onClick={() => fetchUsers()}>Load Users</button>
      {loading && <p>Loading...</p>}
      {error && <p>Error fetching users</p>}
      <ul>
        {users.map((user) => {
          return <li>{user.name} - {user.email}</li>
        })}
      </ul>
    </div>
  )
}

export default UserList;

