import 'package:equatable/equatable.dart';
enum ChannelType { text, announcement }

ChannelType _channelTypeFrom(String? raw) {
  switch (raw) {
    case 'announcement':
      return ChannelType.announcement;
    case 'text':
    default:
      return ChannelType.text;
  }
}

String _channelTypeToString(ChannelType type) {
  switch (type) {
    case ChannelType.announcement:
      return 'announcement';
    case ChannelType.text:
    default:
      return 'text';
  }
}

class Channel extends Equatable {
  const Channel({
    required this.id,
    required this.communityId,
    required this.name,
    required this.slug,
    required this.type,
    this.parentId,
    this.position = 0,
    this.isPrivate = false,
  });

  factory Channel.fromJson(Map<String, dynamic> json) {
    return Channel(
      id: json['id'] as int,
      communityId: json['community_id'] as int? ?? json['communityId'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String? ?? '',
      type: _channelTypeFrom(json['type'] as String?),
      parentId: json['parent_id'] as int? ?? json['parentId'] as int?,
      position: json['position'] as int? ?? 0,
      isPrivate: json['is_private'] as bool? ?? json['isPrivate'] as bool? ?? false,
    );
  }

  final int id;
  final int communityId;
  final String name;
  final String slug;
  final ChannelType type;
  final int? parentId;
  final int position;
  final bool isPrivate;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'community_id': communityId,
        'name': name,
        'slug': slug,
        'type': _channelTypeToString(type),
        'parent_id': parentId,
        'position': position,
        'is_private': isPrivate,
      };

  @override
  List<Object?> get props => [id, communityId, name, type, parentId, position, isPrivate];
}
