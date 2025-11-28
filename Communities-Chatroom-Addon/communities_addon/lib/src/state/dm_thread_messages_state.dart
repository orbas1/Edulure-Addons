part of 'dm_thread_messages_cubit.dart';

enum DMThreadMessagesStatus { initial, loading, loaded, error }

class DMThreadMessagesState extends Equatable {
  const DMThreadMessagesState({
    required this.status,
    this.messages = const [],
    this.errorMessage,
  });

  factory DMThreadMessagesState.initial() => const DMThreadMessagesState(status: DMThreadMessagesStatus.initial);

  final DMThreadMessagesStatus status;
  final List<DMMessage> messages;
  final String? errorMessage;

  DMThreadMessagesState copyWith({DMThreadMessagesStatus? status, List<DMMessage>? messages, String? errorMessage}) {
    return DMThreadMessagesState(
      status: status ?? this.status,
      messages: messages ?? this.messages,
      errorMessage: errorMessage ?? this.errorMessage,
    );
  }

  @override
  List<Object?> get props => [status, messages, errorMessage];
}
