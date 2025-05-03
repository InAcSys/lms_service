namespace LMSService.Application.Services.Interfaces
{
    public interface IService<T, TKey>
    {
        public Task<IEnumerable<T>> GetAll(int pageNumber, int pageSize);
        public Task<T?> GetById(TKey id);
        public Task<T> Update(TKey id, T entity);
        public Task<bool> Delete(TKey id);
    }
}
