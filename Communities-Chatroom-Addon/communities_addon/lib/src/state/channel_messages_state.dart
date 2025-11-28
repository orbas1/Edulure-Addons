part of 'channel_messages_cubit.dart';

enum ChannelMessagesStatus { initial, loading, loaded, error }

class ChannelMessagesState extends Equatable {
  const ChannelMessagesState({
    required this.status,
    this.messages = const [],
    this.errorMessage,
  });

  factory ChannelMessagesState.initial() => const ChannelMessagesState(status: ChannelMessagesStatus.initial);

  final ChannelMessagesStatus status;
  final List<ChannelMessage> messages;
  final String? errorMessage;

  ChannelMessagesState copyWith({ChannelMessagesStatus? status, List<ChannelMessage>? messages, String? errorMessage}) {
    return ChannelMessagesState(
      status: status ?? this.status,
      messages: messages ?? this.messages,
      errorMessage: errorMessage ?? this.errorMessage,
    );
  }

  @override
  List<Object?> get props => [status, messages, errorMessage];
}
