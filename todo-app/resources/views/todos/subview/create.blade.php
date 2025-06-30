<div class="modal fade" id="todo-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{route('todos.store')}}" method="POST" id="todo-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group py-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title" id="title">
                    </div>

                    <div class="form-group py-2">
                        <label for="description">Description</label>
                        <textarea type="text" class="form-control" name="description" placeholder="Description" id="description"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-save">Save</button>
                </div>
                <input type="hidden" id="hidden-todo-id" value="">
            </form>

        </div>
    </div>
</div>
