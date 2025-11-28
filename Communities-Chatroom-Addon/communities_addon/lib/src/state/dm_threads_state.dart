part of 'dm_threads_cubit.dart';

enum DMThreadsStatus { initial, loading, loaded, error }

class DMThreadsState extends Equatable {
  const DMThreadsState({
    required this.status,
    this.threads = const [],
    this.errorMessage,
  });

  factory DMThreadsState.initial() => const DMThreadsState(status: DMThreadsStatus.initial);

  final DMThreadsStatus status;
  final List<DMThread> threads;
  final String? errorMessage;

  DMThreadsState copyWith({DMThreadsStatus? status, List<DMThread>? threads, String? errorMessage}) {
    return DMThreadsState(
      status: status ?? this.status,
      threads: threads ?? this.threads,
      errorMessage: errorMessage ?? this.errorMessage,
    );
  }

  @override
  List<Object?> get props => [status, threads, errorMessage];
}
