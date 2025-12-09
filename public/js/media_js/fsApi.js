export default class fsApi {

    static async post(url, data) {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        return await response.json();
    }

    static async get(url) {
        const response = await fetch(url, {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });
        return await response.json();
    }

    static createFolder(name, path) {
        return this.post("/admin/create-folder", { name, path });
    }

    static deleteFolder(path) {
        return this.post("/admin/delete-folder", { path });
    }

    static renameFolder(path, newName) {
        return this.post("/admin/rename-folder", { path, newName });
    }

    static uploadFile(path, file) {
        const form = new FormData();
        form.append("file", file);
        form.append("path", path);

        return fetch("/admin/upload-file", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: form
        }).then(r => r.json());
    }
}