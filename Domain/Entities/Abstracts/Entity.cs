using System.Text.Json.Serialization;
using LMSService.Domain.Entities.Interfaces;

namespace LMSService.Domain.Entities.Abstracts
{
    public abstract class Entity<TKey> : IEntity<TKey>
    {
        [JsonPropertyName("id")]
        public TKey? Id { get; set; }
    }
}
