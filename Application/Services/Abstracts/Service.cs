using LMSService.Application.Services.Interfaces;

namespace LMSService.Application.Services.Abstracts
{
    public abstract class Service<T, TKey> : IService<T, TKey>
    {
        public abstract Task<T> Create(T entity);

        public abstract Task<bool> Delete(TKey id);

        public abstract Task<IEnumerable<T>> GetAll(int pageNumber, int pageSize);

        public abstract Task<T?> GetById(TKey id);

        public abstract Task<T> Update(TKey id, T entity);
    }
}
