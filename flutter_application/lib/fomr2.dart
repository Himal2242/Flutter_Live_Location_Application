import 'package:flutter/material.dart';
import 'package:flutter/src/widgets/framework.dart';
import 'package:flutter/src/widgets/placeholder.dart';

class dis extends StatefulWidget {
  const dis({super.key});

  @override
  State<dis> createState() => _disState();
}

class _disState extends State<dis> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          Text("data"),
        ],
      ),
    );
  }
}
