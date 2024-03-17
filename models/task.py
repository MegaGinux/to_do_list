from . import db

class Task(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), nullable=False)
    priority = db.Column(db.String(50), nullable=False)
    time = db.Column(db.String(10), nullable=False)
    status = db.Column(db.String(50), nullable=False)

    def __repr__(self):
        return f"Task('{self.name}', '{self.priority}', '{self.time}', '{self.status}')"
