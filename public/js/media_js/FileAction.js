import IFileSystemAction from "./IFileSystemAction.js";
import fsApi from "./fsApi.js";

export default class FileAction extends IFileSystemAction {

    async create(file, path) {
        return await fsApi.uploadFile(path, file);
    }

    async delete(path) {
        return await fsApi.post("/admin/delete-file", { path });
    }

    async rename(path, newName) {
        return await fsApi.post("/admin/rename-file", { path, newName });
    }
}