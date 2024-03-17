from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)

# Lista de tareas
tasks = []

@app.route('/')
def index():
    indexed_tasks = [(idx, task) for idx, task in enumerate(tasks)]
    return render_template('index.html', tasks=indexed_tasks)


@app.route('/add_task', methods=['POST'])
def add_task():
    task_name = request.form['task']
    priority = request.form['priority']
    time = request.form['time']
    status = request.form['status']
    task = {'name': task_name, 'priority': priority, 'time': time, 'status': status}
    tasks.append(task)
    return redirect(url_for('index'))

@app.route('/delete_task/<int:task_id>', methods=['POST'])
def delete_task(task_id):
    if 0 <= task_id < len(tasks):
        del tasks[task_id]
    return redirect(url_for('index'))


@app.route('/edit_task/<int:task_id>', methods=['GET', 'POST'])
def edit_task(task_id):
    if request.method == 'POST':
        task_name = request.form['task']
        priority = request.form['priority']
        time = request.form['time']
        status = request.form['status']
        tasks[task_id]['name'] = task_name
        tasks[task_id]['priority'] = priority
        tasks[task_id]['time'] = time
        tasks[task_id]['status'] = status
        return redirect(url_for('index'))
    else:
        task = tasks[task_id] if 0 <= task_id < len(tasks) else None
        return render_template('edit.html', task=task, task_id=task_id)
    
if __name__ == '__main__':
    app.run(debug=True)
