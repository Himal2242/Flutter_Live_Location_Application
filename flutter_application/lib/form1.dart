import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/src/widgets/framework.dart';
import 'package:flutter/src/widgets/placeholder.dart';
import 'package:flutter_application_1/fomr2.dart';
import 'package:http/http.dart' as http;

class form1 extends StatefulWidget {
  const form1({super.key});

  @override
  State<form1> createState() => _form1State();
}

class _form1State extends State<form1> {
  TextEditingController name = TextEditingController();
  TextEditingController mobile = TextEditingController();

  late bool error, sending, sucess;
  late String msg;
  late String gender1;
  String purl = "http://localhost/test/1.php";

  void initState() {
    error = false;
    sending = false;
    sucess = false;
    msg = "";
    super.initState();
  }

  Future<void> sendData() async {
    var res = await http.post(Uri.parse(purl), body: {
      "name": name.text,
      "mobile": mobile.text,
      "gender": gender1,
    });

    if (res.statusCode == 200) {
      print(res.body);
      var data = json.decode(res.body);

      if (data["erroe"]) {
        setState(() {
          sending = false;
          error = true;
          msg = data["message"];
        });
      } else {
        name.text = "";
        mobile.text = "";
        gender1 = "";

        setState(() {
          sending = false;
          sucess = true;
        });
      }
    } else {
      setState(() {
        error = true;
        msg = "Sending errror";
        sending = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    String? dropvalue = "Select";
    return Scaffold(
      body: Column(
        children: [
          Icon(Icons.access_alarm_sharp),
          Text(
            "Dhaval",
            style: TextStyle(color: Colors.amber, fontSize: 20),
          ),
          // Name

          Padding(
            padding: const EdgeInsets.all(8.0),
            child: TextField(
              controller: name,
              decoration: InputDecoration(
                enabledBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.black),
                  borderRadius: BorderRadius.circular(10),
                ),
                focusedBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.orange),
                  borderRadius: BorderRadius.circular(10),
                ),
                hintText: "Name",
                label: Text("Name"),
              ),
            ),
          ),

          // Mobile

          Padding(
            padding: const EdgeInsets.all(8.0),
            child: TextField(
              controller: mobile,
              decoration: InputDecoration(
                enabledBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.black),
                  borderRadius: BorderRadius.circular(10),
                ),
                focusedBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.orange),
                  borderRadius: BorderRadius.circular(10),
                ),
                hintText: "Mobile",
                label: Text("Mobile"),
              ),
            ),
          ),

          //Gender

          Padding(
            padding: const EdgeInsets.all(8.0),
            child: DropdownButtonFormField<String>(
              decoration: InputDecoration(
                enabledBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.black),
                  borderRadius: BorderRadius.circular(10),
                ),
                focusedBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.orange),
                  borderRadius: BorderRadius.circular(10),
                ),
                hintText: "Gender",
              ),
              value: dropvalue,
              items: <String>['Select', 'Male', 'Female']
                  .map<DropdownMenuItem<String>>((String Value) {
                return DropdownMenuItem<String>(
                  value: Value,
                  child: Text(
                    Value,
                    style: TextStyle(fontSize: 15),
                  ),
                );
              }).toList(),
              onChanged: (String? newValue) {
                setState(() {
                  dropvalue = newValue;
                  gender1 = dropvalue!;
                });
              },
            ),
          ),

          // Button
          Padding(
            padding: const EdgeInsets.all(8.0),
            child: ElevatedButton(
                onPressed: () {
                  setState(() {
                    sending = true;
                  });
                  sendData();
                  Navigator.of(context)
                      .push(MaterialPageRoute(builder: (context) => dis()));
                },
                child: Text("Submit")),
          ),
        ],
      ),
    );
  }
}
