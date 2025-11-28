import 'package:flutter/material.dart';

import '../../models/heatmap_point.dart';

class HeatmapView extends StatelessWidget {
  const HeatmapView({super.key, required this.points});

  final List<HeatmapPoint> points;

  @override
  Widget build(BuildContext context) {
    if (points.isEmpty) {
      return const Center(child: Text('No activity yet'));
    }
    final max = points.map((e) => e.count).fold<int>(0, (prev, curr) => curr > prev ? curr : prev);
    return GridView.count(
      crossAxisCount: 7,
      children: points
          .map(
            (p) => Container(
              margin: const EdgeInsets.all(2),
              decoration: BoxDecoration(
                color: _colorForValue(context, p.count, max),
                borderRadius: BorderRadius.circular(4),
              ),
              child: Tooltip(message: '${p.date.toLocal().toIso8601String().substring(0, 10)}: ${p.count}'),
            ),
          )
          .toList(),
    );
  }

  Color _colorForValue(BuildContext context, int value, int max) {
    if (max == 0) return Colors.grey.shade200;
    final intensity = value / max;
    return Color.lerp(Colors.lightBlue.shade50, Colors.blue.shade700, intensity)!;
  }
}
