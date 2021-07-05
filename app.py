from flask import Flask, request , render_template
from flask_restful import Api
from flask_cors import CORS
import os
import librosa
import numpy as np
import pandas as pd
import pickle
import sklearn
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler


app = Flask(__name__)
CORS(app)
api = Api(app)
emotions = {
    '01':'neutral',
    '02':'calm',
    '03':'happy',
    '04':'sad',
    '05':'angry',
    '06':'fearful',
    '07':'disgust',
    '08':'surprised'
}
model = pickle.load(open('model_final_svn.p','rb'))
X_data = pd.read_csv('data2.csv').iloc[:,1:]
print(X_data)
Y_data = pd.read_csv('Ydata2.csv').iloc[:,1:]
print(X_data.shape,Y_data.shape[0])
X_train , X_test , Y_train, Y_test = train_test_split(X_data,Y_data,test_size = 0.2)
X_train=X_train.to_numpy()
X_text= X_test.to_numpy()
#new_model = tf.keras.models.load_model('cnn_pickle_model.h5')
#Show the model architecture
#new_model.summary()
print(X_train.shape)
lst=[]
sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)
answer=""

def extract_feature(file_name, mfcc):
  X , sample_rate = librosa.load(os.path.join(file_name),res_type='kaiser_fast')
  result=np.array([])
  if mfcc:
    mfccs = np.mean(librosa.feature.mfcc(y=X, sr=sample_rate , n_mfcc=77).T , axis=0)
    # x is numpy array equal to values = sr*duration of sound
    result = np.hstack((result,mfccs))
  return result


@app.route('/callPredictor', methods = ['POST'])
def upldfile():
    if request.method == 'POST':
        file = request.files['file']
        print(file)
        #upload the file to a local folder
        file.save(os.path.join("uploads", file.filename))
        #model.summary()
        feature = extract_feature("uploads/"+file.filename, mfcc=True)
        #feature = extract_feature(file, mfcc=True)
        print(feature)
        y = model.predict(sc.transform([feature]))
        print(emotions[y[0]])
        answer=emotions[y[0]]
    return answer
    #return render_template('Results.html')


@app.route("/")
def index():
    return render_template('UI2.php',content='Yet to predict')


if __name__ == "__main__":
    app.run(debug=True)
