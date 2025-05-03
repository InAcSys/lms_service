using LMSService.Infrastructure.Repositories.Interfaces;

namespace LMSService.Infrastructure.Repositories.Abstracts
{
    public abstract class Repository<T, TKey> : IRepository<T, TKey>
    {
        public abstract Task<T?> Create(T entity);

        public abstract Task<T?> Delete(TKey id);

        public abstract Task<IEnumerable<T>> GetAll(int pageNumber, int pageSize);

        public abstract Task<T?> GetById(TKey id);

        public abstract Task<T?> Update(TKey id, T entity);
    }
}
