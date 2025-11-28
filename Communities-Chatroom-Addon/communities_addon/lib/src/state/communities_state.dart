part of 'communities_cubit.dart';

abstract class CommunitiesState extends Equatable {
  @override
  List<Object?> get props => [];
}

class CommunitiesInitial extends CommunitiesState {}

class CommunitiesLoading extends CommunitiesState {}

class CommunitiesLoaded extends CommunitiesState {
  CommunitiesLoaded(this.communities);
  final List<Community> communities;

  @override
  List<Object?> get props => [communities];
}

class CommunitiesError extends CommunitiesState {
  CommunitiesError(this.message);
  final String message;

  @override
  List<Object?> get props => [message];
}
