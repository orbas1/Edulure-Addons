import 'package:equatable/equatable.dart';
class HeatmapPoint extends Equatable {
  const HeatmapPoint({
    required this.date,
    required this.count,
  });

  factory HeatmapPoint.fromJson(Map<String, dynamic> json) {
    return HeatmapPoint(
      date: DateTime.parse(json['date'] as String? ?? DateTime.now().toIso8601String()),
      count: json['count'] as int? ?? 0,
    );
  }

  final DateTime date;
  final int count;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'date': date.toIso8601String(),
        'count': count,
      };

  @override
  List<Object?> get props => [date, count];
}
