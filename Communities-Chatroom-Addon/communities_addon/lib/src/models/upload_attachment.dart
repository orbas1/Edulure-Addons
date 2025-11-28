import 'package:equatable/equatable.dart';
enum ScanStatus { pending, clean, infected, failed }

ScanStatus _scanStatusFrom(String? raw) {
  switch (raw) {
    case 'clean':
      return ScanStatus.clean;
    case 'infected':
      return ScanStatus.infected;
    case 'failed':
      return ScanStatus.failed;
    case 'pending':
    default:
      return ScanStatus.pending;
  }
}

String _scanStatusToString(ScanStatus status) {
  switch (status) {
    case ScanStatus.clean:
      return 'clean';
    case ScanStatus.infected:
      return 'infected';
    case ScanStatus.failed:
      return 'failed';
    case ScanStatus.pending:
    default:
      return 'pending';
  }
}

class UploadAttachment extends Equatable {
  const UploadAttachment({
    required this.id,
    required this.url,
    required this.originalName,
    required this.mimeType,
    required this.size,
    this.scanStatus = ScanStatus.pending,
  });

  factory UploadAttachment.fromJson(Map<String, dynamic> json) {
    return UploadAttachment(
      id: json['id'] as int,
      url: json['url'] as String? ?? '',
      originalName: json['original_name'] as String? ?? json['originalName'] as String? ?? '',
      mimeType: json['mime_type'] as String? ?? json['mimeType'] as String? ?? '',
      size: json['size'] as int? ?? 0,
      scanStatus: _scanStatusFrom(json['scan_status'] as String? ?? json['scanStatus'] as String?),
    );
  }

  final int id;
  final String url;
  final String originalName;
  final String mimeType;
  final int size;
  final ScanStatus scanStatus;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'url': url,
        'original_name': originalName,
        'mime_type': mimeType,
        'size': size,
        'scan_status': _scanStatusToString(scanStatus),
      };

  @override
  List<Object?> get props => [id, url, originalName, mimeType, size, scanStatus];
}
