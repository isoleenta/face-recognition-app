import json
import os

import face_recognition
import time
from os import listdir
from os.path import isfile, join
import numpy as np
import argparse
from ast import literal_eval


def compare_photos(labeled_face_portraits_encoded, names, unknown_face_path):
    loaded_unknown_face = face_recognition.load_image_file(unknown_face_path)

    start_encode = time.time()
    encoded_unknown_face = face_recognition.face_encodings(loaded_unknown_face)

    end_encode = time.time()
    #
    start_recognize = time.time()
    #

    results = face_recognition.compare_faces(np.array(labeled_face_portraits_encoded), encoded_unknown_face)
    face_distances = face_recognition.face_distance(np.array(labeled_face_portraits_encoded), encoded_unknown_face)
    best_match_index = np.argmin(face_distances)
    if results[best_match_index]:
        name = names[best_match_index]
        print(name)

    end_recognize = time.time()

    # print("encoding time: " + str(end_encode - start_encode) +
    #       "\nrecognize time: " + str(end_recognize - start_recognize) +
    #       "\nall time: " + str(end_recognize - start_encode))


def create_model_from_image(path):
    image = face_recognition.load_image_file(path)  # "./images/biden.png"
    face_encoding = face_recognition.face_encodings(image)[0]

    return face_encoding.tolist()


# compare_two_photos()


parser = argparse.ArgumentParser(description='A test program.')
parser.add_argument("-r", "--route_to_image", help="output: encoded face")
parser.add_argument("-m", "--models", help="labeled models")
parser.add_argument("-n", "--names", help="labeled models")
parser.add_argument("-recognize", "--route_to_image_to_recognize", help="route to image to recognize", type=str)

args = parser.parse_args()
if args.models and not args.names:
    print(literal_eval(args.models))
if args.route_to_image:
    print(create_model_from_image(args.route_to_image))
if args.route_to_image_to_recognize:
    print(compare_photos(literal_eval(args.models), literal_eval(args.names), args.route_to_image_to_recognize))

# compare_photos()
