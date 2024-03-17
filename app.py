from flask import Flask, render_template, request, redirect, url_for
from flask_sqlalchemy import SQLAlchemy
from flask_migrate import Migrate

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://root:root@localhost/todolist'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False  # Para evitar advertencias de seguimiento
db = SQLAlchemy(app)
migrate = Migrate(app, db)

class Task(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), nullable=False)
    priority = db.Column(db.String(50), nullable=False)
    time = db.Column(db.String(10), nullable=False)
    status = db.Column(db.String(50), nullable=False)

    def __repr__(self):
        return f"Task('{self.name}', '{self.priority}', '{self.time}', '{self.status}')"

@app.route('/')
def index():
    tasks = Task.query.all()
    return render_template('index.html', tasks=tasks)

@app.route('/add_task', methods=['POST'])
def add_task():
    task_name = request.form['task']
    priority = request.form['priority']
    time = request.form['time']
    status = request.form['status']
    new_task = Task(name=task_name, priority=priority, time=time, status=status)
    db.session.add(new_task)
    db.session.commit()
    return redirect(url_for('index'))

@app.route('/delete_task/<int:task_id>', methods=['POST'])
def delete_task(task_id):
    task = Task.query.get_or_404(task_id)
    db.session.delete(task)
    db.session.commit()
    return redirect(url_for('index'))

@app.route('/edit_task/<int:task_id>', methods=['GET', 'POST'])
def edit_task(task_id):
    task = Task.query.get_or_404(task_id)
    if request.method == 'POST':
        task.name = request.form['task']
        task.priority = request.form['priority']
        task.time = request.form['time']
        task.status = request.form['status']
        db.session.commit()
        return redirect(url_for('index'))
    return render_template('edit.html', task=task)

if __name__ == '__main__':
    app.run(debug=True)
