import React, { useState, useEffect } from "react";
import axios from "axios";

const Permission = () => {
  const [users, setUsers] = useState([]);
  const [permissions, setPermissions] = useState([]);
  const [loading, setLoading] = useState(true);

  // Fetch all users and their roles/permissions
  useEffect(() => {
    fetchUsersAndPermissions();
  }, []);

  const fetchUsersAndPermissions = async () => {
    try {
      const response = await axios.get(
        "http://127.0.0.1:8000/api/get-user-roles-permission"
      );

      const fetchedUsers = response.data;

      // Extract unique permissions to use as column headings
      const uniquePermissions = new Set();
      fetchedUsers.forEach((user) =>
        user.permissions.forEach((perm) => uniquePermissions.add(perm.name))
      );

      setPermissions([...uniquePermissions]); // Convert Set to Array
      setUsers(fetchedUsers);
    } catch (error) {
      console.error("Error fetching users and permissions:", error);
    } finally {
      setLoading(false);
    }
  };

  // Handle toggling permissions
  const handlePermissionToggle = async (
    userId,
    permissionName,
    hasPermission
  ) => {
    const url = hasPermission
      ? "http://127.0.0.1:8000/api/superadmin/permissions/revoke"
      : "http://127.0.0.1:8000/api/superadmin/permissions/assign";

    const permissionId = getPermissionIdByName(permissionName);

    if (!permissionId) {
      alert(`Permission ID not found for ${permissionName}.`);
      return;
    }

    try {
      const response = await axios.post(url, {
        user_id: userId,
        permission_id: permissionId,
      });
      alert(response.data.message); // Show success message
      await fetchUsersAndPermissions(); // Refresh data after toggling
    } catch (error) {
      console.error(
        "Error updating permission:",
        error.response?.data || error
      );
      alert("Failed to update permission. Check console for details.");
    }
  };

  // Helper function to find permission ID by name
  const getPermissionIdByName = (permissionName) => {
    const permission = users
      .flatMap((user) => user.permissions)
      .find((perm) => perm.name === permissionName);
    return permission ? permission.id : null;
  };

  if (loading) return <p>Loading...</p>;

  return (
    <div>
      <h1>User Permissions</h1>
      <table border="1" cellPadding="10" cellSpacing="0">
        <thead>
          <tr>
            <th>User</th>
            {permissions.map((perm, index) => (
              <th key={index}>{perm}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {users.map((user) => (
            <tr key={user.user_id}>
              <td>{user.name}</td>
              {permissions.map((perm) => {
                // Check if the user has this permission
                const userPermission = user.permissions.find(
                  (p) => p.name === perm
                );

                return (
                  <td key={perm}>
                    <input
                      type="checkbox"
                      checked={!!userPermission} // If userPermission exists, check the box
                      onChange={() =>
                        handlePermissionToggle(
                          user.user_id,
                          perm,
                          !!userPermission // Pass current permission state
                        )
                      }
                    />
                  </td>
                );
              })}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Permission;
