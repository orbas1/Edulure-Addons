part of 'community_detail_cubit.dart';

enum CommunityDetailStatus { initial, loading, loaded, error }

class CommunityDetailState extends Equatable {
  const CommunityDetailState({
    required this.status,
    this.community,
    this.channels = const [],
    this.errorMessage,
  });

  factory CommunityDetailState.initial() => const CommunityDetailState(status: CommunityDetailStatus.initial);

  final CommunityDetailStatus status;
  final Community? community;
  final List<Channel> channels;
  final String? errorMessage;

  CommunityDetailState copyWith({
    CommunityDetailStatus? status,
    Community? community,
    List<Channel>? channels,
    String? errorMessage,
  }) {
    return CommunityDetailState(
      status: status ?? this.status,
      community: community ?? this.community,
      channels: channels ?? this.channels,
      errorMessage: errorMessage ?? this.errorMessage,
    );
  }

  @override
  List<Object?> get props => [status, community, channels, errorMessage];
}
