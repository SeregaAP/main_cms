import IAction from "./IFileSystemAction.js";
import fsApi from "./fsApi.js";

export default class FolderAction extends IAction {

    async getTree(path = '') {
        // fsApi.get может быть добавлен в fsApi.js
        return await fsApi.get(`/admin/media/tree?path=${encodeURIComponent(path)}`);
    }
    
    async create(folder, path) {
        return await fsApi.post("/admin/create-folder", { folder, path });
    }

    async delete(path) {
        return await fsApi.post("/admin/delete-folder", { path });
    }

    async rename(path, newName) {
        return await fsApi.post("/media/folder/rename", { path, newName });
    }
}