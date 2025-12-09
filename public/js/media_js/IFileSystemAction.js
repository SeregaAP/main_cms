export default class IFileSystemAction {
    create(name, path) {
        throw new Error("Method 'create' must be implemented.");
    }

    delete(path) {
        throw new Error("Method 'delete' must be implemented.");
    }

    rename(path, newName) {
        throw new Error("Method 'rename' must be implemented.");
    }
}